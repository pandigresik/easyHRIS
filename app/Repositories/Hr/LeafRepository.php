<?php

namespace App\Repositories\Hr;

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
                $model = parent::create($input);     
                \Log::error($model);                         
                $model->details()->sync($details);
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
            $model->fill($input);
            $model->save();
            $details = [];
            foreach(CarbonPeriod::create($leaveStart, $leaveEnd) as $date ){
                $details[] = ['leave_date' => $date->format('Y-m-d')];
            }
            $model->details()->sync($details);
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
}
