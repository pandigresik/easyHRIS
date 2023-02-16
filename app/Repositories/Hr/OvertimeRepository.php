<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Library\SalaryComponent\Overtime as SalaryComponentOvertime;
use App\Models\Base\Setting;
use App\Models\Hr\Employee;
use App\Models\Hr\Overtime;
use App\Models\Hr\SalaryBenefit;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Exception;

/**
 * Class OvertimeRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 8:16 am WIB
*/

class OvertimeRepository extends BaseRepository
{
    private $maxStepApproval = 0;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'approved_by_id',
        'overtime_date',
        'start_hour',
        'end_hour',
        'start_hour_real',
        'end_hour_real',
        'raw_value',
        'calculated_value',
        'holiday',
        'overday',
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
        return Overtime::class;
    }

    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $setting = Setting::where(['type' => 'approval'])->get()->keyBy('name');
            $employees = $input['employee_id'];
            unset($input['employee_id']);
            $this->setMaxStepApproval(intval($setting['max_approval_overtime']->value ?? 0));
            if(is_null($input['breaktime_value'])){
                $input['breaktime_value'] = 0;
            }
            foreach($employees as $employee){
                $input['employee_id'] = $employee;
                // pastikan tidak ada yang kembar data overtimenya
                $this->isOvertimeExist($input);    
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
                // execute job attendance process after 30 seconds                
                $this->generateJob($model);
            }
                        
            $this->model->getConnection()->commit();
        } catch (\Exception $e) {
            // \Log::error($e->getMessage());
            $this->model->getConnection()->rollBack();

            return $e;
        }

        return $model;
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{            
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            // pastikan tidak ada yang kembar data overtimenya
            $this->isOvertimeExist($input, $model);
            $model->fill($input);
            $salaryBenefit = SalaryBenefit::where(['employee_id' => $model->employee_id])->where('component_id', function($q){
                return $q->select(['id'])->from('salary_components')->where(['code' => 'OT']);
            })->first();
            $amountOvertime = $salaryBenefit->getRawOriginal('benefit_value');
            $model->amount = (new  SalaryComponentOvertime(minuteToHour($model->calculated_value) , $amountOvertime))->calculate();
            $model->save();
            $this->model->getConnection()->commit();
            // execute job attendance process after 30 seconds                
            $this->generateJob($model);
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function isOvertimeExist($overtime, $model = NULL){
        $first = Overtime::where(['employee_id' => $overtime['employee_id'], 'start_hour' => $overtime['start_hour'], 'overtime_date' => $overtime['overtime_date']])->first();
        if($first){
            if($model){                
                if($model->id == $first->id){                    
                    // allow update data except overtime_date and start_hour 
                    if($model->getRawOriginal('overtime_date') == $first->getRawOriginal('overtime_date')){
                        if($model->getRawOriginal('start_hour') == $first->getRawOriginal('start_hour')){
                            return;
                        }
                    }
                }                
            }         
            $employee = Employee::find($overtime['employee_id']);
            throw new Exception("Data overtime karyawan ".$employee->code_name. " tanggal ".$first->overtime_date." jam ".$first->start_hour." sudah ada");
        }
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
        $requestOvertime = $this->model->whereIn('id', $reference)->with(['approvals'])->get();
        $this->model->getConnection()->beginTransaction();
        try {
            foreach($requestOvertime as $item){
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
        $requestOvertime = $this->model->whereIn('id', $reference)->with(['approvals'])->get();
        $this->model->getConnection()->beginTransaction();
        try {
            foreach($requestOvertime as $item){
                $item->setCurrentStep($item->getRawOriginal('step_approval'));
                $item->setMaxStep($item->getRawOriginal('amount_approval'));
                $item->approveAction();
                $item->step_approval = $item->step_approval + 1;
                $item->status = $item->getNextState();
                $item->save();
                $item->approvals()->update(['status' => $item->getNextState(), 'updated_by' => \Auth::id()]);
                // execute job attendance process after 30 seconds                
                $this->generateJob($item, 30);
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
        // if($item->getRawOriginal('status') == $item->getFinalState()){
            if($item->getRawOriginal('overtime_date') < Carbon::now()->format('Y-m-d')){
                AttendanceProcess::dispatch($item->employee_id, $item->getRawOriginal('overtime_date'), $item->getRawOriginal('overtime_date'))->delay(now()->addSeconds($delay));
            }                    
        // }
    }
}
