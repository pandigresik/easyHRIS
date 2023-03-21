<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Models\Base\Setting;
use App\Models\Hr\Employee;
use App\Models\Hr\RequestWorkshift;
use App\Models\Hr\Shiftment;
use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;

/**
 * Class RequestWorkshiftRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 10:11 am WIB
*/

class RequestWorkshiftRepository extends BaseRepository
{
    private $maxStepApproval = 0;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'shiftment_id_origin',
        'work_date',
        'status',
        'description'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RequestWorkshift::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $setting = Setting::where(['type' => 'approval'])->get()->keyBy('name');
            $workDate = generatePeriod($input['work_date']);
            unset($input['work_date']);
            $employees = $input['employee_id'];
            unset($input['employee_id']);            
            $this->setMaxStepApproval(intval($setting['max_approval_request_workshift']->value ?? 0));
            foreach($employees as $employeeId){
                foreach(CarbonPeriod::create($workDate['startDate'], $workDate['endDate']) as $date){
                    $model = $this->generateWorkshift($employeeId, $input, $date->format('Y-m-d'));
                }
            }            
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function generateWorkshift($employeeId, $input, $workDate){
        //$input['status'] = RequestWorkshift::INITIAL_STATE;
        $input['work_date'] = $workDate;
        $input['employee_id'] = $employeeId;
            $shiftmentOrigin = Workshift::select(['shiftment_id'])->where(['work_date' => $workDate, 'employee_id' => $employeeId])->first();
            if(!$shiftmentOrigin){
                $employeeSelect = Employee::find($employeeId);
                throw new Exception('Jadwal kerja karyawan '.$employeeSelect->code_name.' untuk tanggal '.localFormatDate($workDate).' tidak ditemukan');
            }
            $shiftmentId = $input['shiftment_id'];
            $newShiftmentId = Shiftment::with(['schedules' => function($q) use($workDate){
                $workDay = Carbon::parse($workDate)->dayOfWeek;
                return $q->where(['work_day' => $workDay]);
            }])->disableModelCaching()->find($shiftmentId);
            $selectedShiftmentHour = ['start_hour' => $newShiftmentId->getRawOriginal('start_hour'), 'end_hour' => $newShiftmentId->getRawOriginal('end_hour')];
            if(!$newShiftmentId->schedules->isEmpty()){
                $selectedShiftmentHour = ['start_hour' => $newShiftmentId->schedules->first()->getRawOriginal('start_hour'), 'end_hour' => $newShiftmentId->schedules->first()->getRawOriginal('end_hour')];
            }
                        
            $input['start_hour'] = $workDate.' '.$selectedShiftmentHour['start_hour'];
            $workDateEnd = $workDate;
            // case awal shift jam 22.00 misalnya
            if($selectedShiftmentHour['start_hour'] > $selectedShiftmentHour['end_hour']){
                $workDateEnd = Carbon::parse($workDate)->addDay()->format('Y-m-d');
            }
            // case shift 3
            if(substr($selectedShiftmentHour['start_hour'], 0 , 2) == '00'){
                if($selectedShiftmentHour['start_hour'] != $selectedShiftmentHour['end_hour']){
                    $workDateEnd = Carbon::parse($workDate)->addDay()->format('Y-m-d');
                    $input['start_hour'] = $workDateEnd.' '.$selectedShiftmentHour['start_hour'];
                }                
            }
            
            // jika start_hour = end_hour maka set sebagai hari libur
            if($selectedShiftmentHour['start_hour'] == $selectedShiftmentHour['end_hour']){
                $input['shiftment_id'] = config('local.default_shiftment_off_id');
            }
            
            $input['end_hour'] =  $workDateEnd.' '.$selectedShiftmentHour['end_hour'];
            $input['shiftment_id_origin'] = $shiftmentOrigin->shiftment_id;
            $model = $this->model->newInstance($input);//parent::create($input);
            $approvalUsers = \Auth::user()->getApprovalUsers();
            $maxStep = $this->getMaxStepApproval() < count($approvalUsers) ? $this->getMaxStepApproval() : count($approvalUsers);
            $model->initializeApproval($approvalUsers);
            $model->setMaxStep($maxStep);
            $model->status = $model->getDefaultInitialState();
            $model->step_approval = 1;
            $model->amount_approval = $model->getMaxStep();
            $model->save();            
            $model->generateApproval();
            
            if($model->getRawOriginal('status') == $model->getFinalState()){
                $this->updateWorkshift($model);
                // execute job attendance process after 30 seconds
                $this->generateJob($model);
            }
        return $model;
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $changeWorkshift = false;
            $shiftmentChange = false;
            if($model->getRawOriginal('work_date') != $input['work_date']){
                $changeWorkshift = true;
                $shiftmentChange = true;
            }

            if($model->getRawOriginal('shiftment_id') != $input['shiftment_id']){
                $changeWorkshift = true;
                $shiftmentChange = true;
            }

            if($model->getRawOriginal('employee_id') != $input['employee_id']){
                $changeWorkshift = true;
            }

            if($changeWorkshift){
                $workDate = $input['work_date'];
                $employeeId = $input['employee_id'];                
                $shiftmentOrigin = Workshift::select(['shiftment_id'])->where(['work_date' => $workDate, 'employee_id' => $employeeId])->first();
                if(!$shiftmentOrigin){
                    throw new Exception('Jadwal kerja untuk tanggal tersebut tidak ditemukan');
                }

                if($shiftmentChange){
                    $shiftmentId = $input['shiftment_id'];
                    $newShiftmentId = Shiftment::with(['schedules' => function($q) use($workDate){
                        $workDay = Carbon::parse($workDate)->dayOfWeek;
                        return $q->where(['work_day' => $workDay]);
                    }])->disableModelCaching()->find($shiftmentId);
                    $selectedShiftmentHour = ['start_hour' => $newShiftmentId->getRawOriginal('start_hour'), 'end_hour' => $newShiftmentId->getRawOriginal('end_hour')];                    
                    
                    if(!$newShiftmentId->schedules->isEmpty()){                        
                        $selectedShiftmentHour = ['start_hour' => $newShiftmentId->schedules->first()->getRawOriginal('start_hour'), 'end_hour' => $newShiftmentId->schedules->first()->getRawOriginal('end_hour')];
                    }
                    
                    $input['start_hour'] = $workDate.' '.$selectedShiftmentHour['start_hour'];
                    $workDateEnd = $workDate;
                    if($selectedShiftmentHour['start_hour'] > $selectedShiftmentHour['end_hour']){
                        $workDateEnd = Carbon::parse($workDate)->addDay()->format('Y-m-d');
                    }

                    if(substr($selectedShiftmentHour['start_hour'], 0 , 2) == '00'){
                        $workDateEnd = Carbon::parse($workDate)->addDay()->format('Y-m-d');   
                        $input['start_hour'] = $workDateEnd.' '.$selectedShiftmentHour['start_hour'];
                    }

                    $input['end_hour'] =  $workDateEnd.' '.$selectedShiftmentHour['end_hour'];
                    
                    //$input['start_hour'] = $workDate.' '.$newShiftmentId->schedules->first()->getRawOriginal('start_hour');
                    //$input['end_hour'] = $newShiftmentId->schedules->first()->getRawOriginal('start_hour') > $newShiftmentId->schedules->first()->getRawOriginal('end_hour') ? Carbon::parse($workDate)->addDay()->format('Y-m-d').' '.$newShiftmentId->schedules->first()->getRawOriginal('end_hour') : $workDate.' '.$newShiftmentId->schedules->first()->getRawOriginal('end_hour');
                }
            }
                        
            $model->fill($input);            
            $model->save();
            if($model->getRawOriginal('status') == $model->getFinalState()){
                $this->updateWorkshift($model);
                // execute job attendance process after 30 seconds
                $this->generateJob($model);
            }
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function updateWorkshift($model){
        $workshift = Workshift::where(['employee_id' => $model->employee_id, 'work_date' => $model->getRawOriginal('work_date')])->first();
        $workshift->shiftment_id = $model->shiftment_id;
        $workshift->start_hour = $model->getRawOriginal('start_hour');
        $workshift->end_hour = $model->getRawOriginal('end_hour');
        $workshift->save();        
    }

    public function approveReject($input){
        $action = $input['action'];
        $comment = $input['comment'] ?? null;
        $reference = $input['reference'];
        switch($action){
            case 'RJ':
                $this->reject($reference, $comment);
                break;
            default:
            $this->approve($reference);
        }        
    }

    private function reject($reference, $comment){
        $requestWorkshift = $this->model->whereIn('id', $reference)->with(['approvals'])->get();
        $this->model->getConnection()->beginTransaction();
        try {
            foreach($requestWorkshift as $item){
                $item->step_approval = $item->step_approval - 1;
                $item->rejectAction();
                $item->status = $item->getNextState();
                $item->save();

                $item->approvals()->update(['comment' => $comment, 'status' => $item->getNextState(), 'updated_by' => \Auth::id()]);
            }
            $this->model->getConnection()->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function approve($reference){
        $requestWorkshift = $this->model->whereIn('id', $reference)->with(['approvals'])->get();
        $this->model->getConnection()->beginTransaction();
        try {
            foreach($requestWorkshift as $item){                
                $item->setCurrentStep($item->getRawOriginal('step_approval'));
                $item->setMaxStep($item->getRawOriginal('amount_approval'));
                $item->approveAction();
                $item->step_approval = $item->step_approval + 1;
                $item->status = $item->getNextState();
                $item->save();
                $item->approvals()->update(['status' => $item->getNextState(), 'updated_by' => \Auth::id()]);
                if($item->getRawOriginal('status') == $item->getFinalState()){
                    $this->updateWorkshift($item);
                    // execute job attendance process after 30 seconds
                    $this->generateJob($item, 30);
                }
            }
            $this->model->getConnection()->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }
    /**
     * Get the value of maxStepApproval
     */ 
    public function getMaxStepApproval()
    {
        return $this->maxStepApproval;
    }

    /**
     * Set the value of maxStepApproval
     *
     * @return  self
     */ 
    public function setMaxStepApproval($maxStepApproval)
    {
        $this->maxStepApproval = $maxStepApproval;

        return $this;
    }    

    private function generateJob($item, $delay = 2){
        // execute job attendance process after 30 seconds                
        if($item->getRawOriginal('status') == $item->getFinalState()){
            if($item->getRawOriginal('work_date') < Carbon::now()->format('Y-m-d')){
                AttendanceProcess::dispatch($item->employee_id, $item->getRawOriginal('work_date'), $item->getRawOriginal('work_date'))->delay(now()->addSeconds($delay));
            }
        }        
    }
}
