<?php

namespace App\Observers;

use App\Models\Hr\AbsentReason;
use App\Models\Hr\Employee;
use App\Models\Hr\Leaf;

class LeafObserver
{
    /**
     * Handle the Leaf "created" event.
     *
     * @param  \App\Models\Hr\Leaf  $leaf
     * @return void
     */
    public function created(Leaf $leaf)
    {
        if($leaf->isAnnualLeave() && $leaf->isCurrentYear()){
            Employee::find($leaf->employee_id)->decrement('leave_balance', intval($leaf->getRawOriginal('amount')));
        }
    }

    /**
     * Handle the Leaf "updated" event.
     *
     * @param  \App\Models\Hr\Leaf  $leaf
     * @return void
     */
    public function updated(Leaf $leaf)
    {
        //
    }

    public function updating(Leaf $leaf){
        // case update reason absent dari CT ke yang lainnya        
        if($leaf->reason_id != $leaf->getOriginal('reason_id') && $leaf->isCurrentYear()){
            $leaveCodeReason = AbsentReason::select(['id','code'])->whereIn('id',[$leaf->getOriginal('reason_id'), $leaf->reason_id])->get()->keyBy('id');
            // increment leave_balance jika reason yang lama adalah cuti tahunan
            if($leaveCodeReason[$leaf->getOriginal('reason_id')]->code == config('local.annual_leave_code')){
                Employee::find($leaf->employee_id)->increment('leave_balance', intval($leaf->getOriginal('amount')));
            }
            // decrement leave_balance jika reason yang baru adalah cuti tahunan
            if($leaveCodeReason[$leaf->reason_id]->code == config('local.annual_leave_code')){
                Employee::find($leaf->employee_id)->decrement('leave_balance', intval($leaf->getOriginal('amount')));
            }
        }
    }

    /**
     * Handle the Leaf "deleted" event.
     *
     * @param  \App\Models\Hr\Leaf  $leaf
     * @return void
     */
    public function deleted(Leaf $leaf)
    {        
        if($leaf->isAnnualLeave() && $leaf->isCurrentYear()){
            Employee::find($leaf->employee_id)->increment('leave_balance', $leaf->getOriginal('amount'));
        }        
    }

    /**
     * Handle the Leaf "restored" event.
     *
     * @param  \App\Models\Hr\Leaf  $leaf
     * @return void
     */
    public function restored(Leaf $leaf)
    {
        //
    }

    /**
     * Handle the Leaf "force deleted" event.
     *
     * @param  \App\Models\Hr\Leaf  $leaf
     * @return void
     */
    public function forceDeleted(Leaf $leaf)
    {
        //
    }
}
