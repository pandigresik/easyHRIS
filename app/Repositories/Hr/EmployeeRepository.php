<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Models\Hr\Contract;
use App\Models\Hr\Employee;
use App\Models\Hr\Payroll;
use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;

/**
 * Class EmployeeRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class EmployeeRepository extends BaseRepository
{        
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'contract_id',
        'company_id',
        'department_id',
        'joblevel_id',
        'jobtitle_id',
        'supervisor_id',
        'region_of_birth_id',
        'city_of_birth_id',
        'address',
        'join_date',
        'employee_status',
        'code',
        'full_name',
        'gender',
        'date_of_birth',
        'identity_number',
        'identity_type',
        'marital_status',
        'email',
        'leave_balance',
        'tax_group',
        'resign_date',
        'have_overtime_benefit',
        'risk_ratio',
        'profile_image',
        'profile_size',
        'salary_group_id',
        'shiftment_group_id'
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
        return Employee::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $model = parent::create($input);
            if($input['contract_id']){
                $this->updateContract($input['contract_id']);
            }
            
            $this->model->getConnection()->commit();
        } catch (\Exception $e) {            
            $this->model->getConnection()->rollBack();

            return $e;
        }

        return $model;
    }
    
    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();

        try {
            $query = $this->model->newQuery();
            $oldContract = $query->find($id);            
            $model = parent::update($input, $id);
            
            if($oldContract->getRawOriginal('resign_date') != $model->getRawOriginal('resign_date')){
                // clean all transaction relation with this employee after resign date
                if($model->getRawOriginal('resign_date')){
                    $this->clearRelationTransaction($model);
                }                
            }
                        
            if($input['contract_id']){                     
                if($oldContract->contract_id != $input['contract_id']){
                    // set unused old contract id
                    $this->updateContract($input['contract_id']);
                    if(!empty($oldContract->contract_id)){
                        $this->updateContract($oldContract->contract_id, 0);
                    }                    
                }
            }else{
                // set unused old contract id
                if($oldContract->contract_id){
                    $this->updateContract($oldContract->contract_id, 0);
                }                
            }
            
            $this->model->getConnection()->commit();
        } catch (\Exception $e) {            
            $this->model->getConnection()->rollBack();

            return $e;
        }

        return $model;
    }

    private function updateContract($contractId, $used = 1){
        $contract = Contract::find($contractId);
        $contract->used = $used;
        $contract->save();        
    }

    /**
     * remove attendance
     * remove workshift
     * remove payrolls
     */
    private function clearRelationTransaction($model){
        Attendance::where(['employee_id' => $model->id])
            ->where('attendance_date','>=', $model->getRawOriginal('resign_date'))
            ->delete();
        Workshift::where(['employee_id' => $model->id])
            ->where('work_date','>=', $model->getRawOriginal('resign_date'))
            ->delete();
        Payroll::where(['employee_id' => $model->id])
            ->whereHas('payrollPeriod', function($q) use ($model) {
                return $q->where('start_period','>=', $model->getRawOriginal('resign_date'));
        })->delete();
    }
}
