<?php
namespace App\Traits;

use App\Models\Base\Approval;

trait ApprovalModelTrait
{
    private $finalState = 'A';
    private $initialState = 'N';
    private $rejectState = 'RJ';
    private $approveState = 'RV';
    private $currentStep = 0;
    private $maxStep = 0;
    private $nextState;
    private $approvalUsers = [];

    public function initializeApproval($approvalUsers){
        $this->setApprovalUsers($approvalUsers);        
    }

    public function generateApproval(){             
        if($this->getApprovalUsers()){
            $approvalInsert = [];
            foreach($this->getApprovalUsers() as $index => $employee){
                $loopIndex = $index + 1;
                
                if($loopIndex > $this->getMaxStep()){
                    continue;
                } 

                $approvalInsert = [
                    'employee_id' => $employee,
                    'model' => __CLASS__,
                    'reference' => $this->id,
                    'status' => NULL,
                    'sequence' => ($index + 1)                    
                ];
                Approval::create($approvalInsert);
            }
            
        }
    }
    
    /** change status to next status */
    public function approveAction(){
        $this->setNextState($this->approveState);
        if($this->getCurrentStep() >= $this->getMaxStep()){
            $this->setNextState($this->finalState);
        }        
    }

    public function rejectAction(){
        $this->setNextState($this->rejectState);
    }

    /**
     * Get the value of currentStep
     */ 
    public function getCurrentStep()
    {
        return $this->currentStep;
    }

    /**
     * Set the value of currentStep
     *
     * @return  self
     */ 
    public function setCurrentStep($currentStep)
    {
        $this->currentStep = $currentStep;

        return $this;
    }

    /**
     * Get the value of maxStep
     */ 
    public function getMaxStep()
    {
        return $this->maxStep;
    }

    /**
     * Set the value of maxStep
     *
     * @return  self
     */ 
    public function setMaxStep($maxStep)
    {
        $this->maxStep = $maxStep;

        return $this;
    }

    /**
     * Get the value of nextState
     */ 
    public function getNextState()
    {
        return $this->nextState;
    }

    /**
     * Set the value of nextState
     *
     * @return  self
     */ 
    public function setNextState($nextState)
    {
        $this->nextState = $nextState;

        return $this;
    }    

    public function getDefaultInitialState(){
        return $this->getCurrentStep() >= $this->getMaxStep() ? $this->finalState : $this->initialState;
    }

    /**
     * Get the value of approvalUsers
     */ 
    public function getApprovalUsers()
    {
        return $this->approvalUsers;
    }

    /**
     * Set the value of approvalUsers
     *
     * @return  self
     */ 
    public function setApprovalUsers($approvalUsers)
    {
        $this->approvalUsers = $approvalUsers;

        return $this;
    }

    public function delete(){
        Approval::where(['model' => __CLASS__, 'reference' => $this->id])->delete();
        return parent::delete();
    }

    /**
     * Get the value of finalState
     */ 
    public function getFinalState()
    {
        return $this->finalState;
    }

    public function getNeedApproval($employeeId, $urlApproval){
        return Approval::selectRaw('count(*) as total, approvals.created_by')
                ->join($this->getTable(), function($q){
                    return $q->on($this->getTable().'.id', '=', 'approvals.reference')
                    ->on($this->getTable().'.step_approval', '=', 'approvals.sequence')
                    ->whereNotIn($this->getTable().'.status', [$this->finalState]);
                })                
                ->with(['createdBy'])
                ->where(['model' => __CLASS__, 'approvals.employee_id' => $employeeId])
                ->groupBy('approvals.created_by')->get()->map(function($item) use ($urlApproval) {
                    return ['created_by' => $item->createdBy->name, 'count' => $item->total, 'url' => $urlApproval.'?created_by='.$item->createdBy->id];
                })->toArray();
    }

    protected function scopeNeedApproval($query, $employeeId, $createdBy = NULL){
        return $query->join('approvals', function($q) use ($employeeId, $createdBy){
            $q->on($this->getTable().'.id', '=', 'approvals.reference')
                ->on($this->getTable().'.step_approval', '=', 'approvals.sequence')
                ->where(['model' => __CLASS__, 'approvals.employee_id' => $employeeId])
                ->whereNotIn($this->getTable().'.status', [$this->finalState, $this->rejectState]);
            if($createdBy){
                $q->where('approvals.created_by', $createdBy);
            }
            return $q;
        });
    }

    public function approvals(){
        $employee = \Auth::user()->employee;
        return $this->hasMany(\App\Models\Base\Approval::class, 'reference', 'id')->where(['model' => __CLASS__, 'employee_id' => $employee->id]);
    }

    public function logApprovals(){        
        return $this->hasMany(\App\Models\Base\Approval::class, 'reference', 'id')->where(['model' => __CLASS__]);
    }

    public function scopeApprove($query){
        return $query->whereStatus($this->finalState);
    }

    public function isApprove(){
        return $this->getRawOriginal('status') == $this->finalState;
    }
}
