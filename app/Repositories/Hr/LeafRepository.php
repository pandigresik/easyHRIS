<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Models\Base\Setting;
use App\Models\Hr\AbsentReason;
use App\Models\Hr\Employee;
use App\Models\Hr\Leaf;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

/**
 * Class LeafRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 9:27 am WIB
*/

class LeafRepository extends BaseRepository
{
    private $maxStepApproval = 0;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'reason_id',
        'leave_start',
        'leave_end',
        'amount',
        'status',
        'step_approval',
        'amount_approval',
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
        return Leaf::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $setting = Setting::where(['type' => 'approval'])->get()->keyBy('name');
            $this->setMaxStepApproval(intval($setting['max_approval_overtime']->value ?? 0));

            $leaveEnd = Carbon::parse($input['leave_end']);
            $leaveStart = Carbon::parse($input['leave_start']);
            $input['amount'] = $leaveEnd->diffInDays($leaveStart) + 1;
            $input['status'] = Leaf::INITIAL_STATE;
            $employees = $input['employee_id'];
            unset($input['employee_id']);
            $details = [];
            foreach(CarbonPeriod::create($leaveStart, $leaveEnd) as $date ){
                $details[] = ['leave_date' => $date->format('Y-m-d')];
            }
            $reason = AbsentReason::find($input['reason_id']);
            $leaveBalance = [];
            if($reason->isAnnualLeave()){
                $leaveBalance = Employee::select(['id', 'code', 'full_name' ,'leave_balance'])->whereIn('id', $employees)->get()->keyBy('id');
                $pendingBalance = Leaf::selectRaw('employee_id, count(*) as total')->whereIn('employee_id', $employees)->where(['reason_id' => $reason->id])->where('status', '<>',Leaf::APPROVE_STATE)->whereYear('leave_start',$leaveStart)->groupBy('employee_id')->get()->keyBy('employee_id');
            }
            foreach($employees as $employee){
                if($leaveBalance){
                    $amountLeave = $input['amount'];
                    $this->isAllowAnnualLeave($amountLeave, $leaveBalance[$employee] ?? null, $pendingBalance[$employee] ?? null);
                }
                
                $input['employee_id'] = $employee;
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

                $model->details()->sync($details);
                
                if($model->getRawOriginal('status') == $model->getFinalState()){
                    // execute job attendance process after 30 seconds                
                    $this->generateJob($model);
                }
            }
            
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {            
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $leaveEnd = Carbon::parse($input['leave_end']);
            $leaveStart = Carbon::parse($input['leave_start']);
            $input['amount'] = $leaveEnd->diffInDays($leaveStart) + 1;

            $reason = AbsentReason::find($input['reason_id']);
            $leaveBalance = [];
            $employee = $input['employee_id'];
            if($reason->isAnnualLeave()){
                $leaveBalance = Employee::select(['id', 'code', 'full_name' ,'leave_balance'])->where('id', $employee)->get()->keyBy('id');
                $pendingBalance = Leaf::selectRaw('employee_id, count(*) as total')->where('employee_id', $employee)->where(['reason_id' => $reason->id])->where('status', '<>',Leaf::APPROVE_STATE)->whereYear('leave_start',$leaveStart)->groupBy('employee_id')->get()->keyBy('employee_id');

                if($leaveBalance){
                    $amountLeave = $input['amount'];
                    $this->isAllowAnnualLeave($amountLeave, $leaveBalance[$employee] ?? null, $pendingBalance[$employee] ?? null);
                }
            }

            $model->fill($input);
            $model->save();
            $details = [];
            foreach(CarbonPeriod::create($leaveStart, $leaveEnd) as $date ){
                $details[] = ['leave_date' => $date->format('Y-m-d')];
            }
            $model->details()->sync($details);
            if($model->getRawOriginal('status') == $model->getFinalState()){
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

    private function isAllowAnnualLeave($amountLeave, $leaveBalance, $pendingBalance){                
        $pending = $pendingBalance ? $pendingBalance->total : 0;
        $countLeave = $leaveBalance ? $leaveBalance->getRawOriginal('leave_balance') - $pending : 0;
        $afterLeave = $countLeave - $amountLeave;
        if($afterLeave <= 0){
            throw new \Exception("Karyawan {$leaveBalance->codeName} Sisa cuti tahunan {$countLeave}, jumlah cuti yang akan diambil {$amountLeave} ");
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
                
                if($item->getRawOriginal('status') == $item->getFinalState()){
                    // execute job attendance process after 30 seconds                
                    $this->generateJob($item);
                }
                
            }
            $this->model->getConnection()->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    private function generateJob($item){
        // execute job attendance process after 30 seconds                
        if($item->getRawOriginal('status') == $item->getFinalState()){       
            $nowDate = Carbon::now()->format('Y-m-d');     
            if(getDateString($item->getRawOriginal('leave_start')) < $nowDate){
                foreach($item->details as $dayDate){
                    if($dayDate->getRawOriginal('leave_date') < $nowDate){
                        AttendanceProcess::dispatch($item->employee_id, $dayDate->getRawOriginal('leave_date'), $dayDate->getRawOriginal('leave_date'))->delay(now()->addSeconds(30));
                    }
                }
            }
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
}
