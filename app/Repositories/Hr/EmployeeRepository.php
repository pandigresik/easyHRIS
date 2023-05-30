<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Models\Hr\Contract;
use App\Models\Hr\Employee;
use App\Models\Hr\Payroll;
use App\Models\Hr\SalaryBenefit;
use App\Models\Hr\SalaryGroupDetail;
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
            $this->createSalaryBenefit($model);
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
            $oldData = $query->find($id);            
            $model = parent::update($input, $id);
            
            if($oldData->getRawOriginal('resign_date') != $model->getRawOriginal('resign_date')){
                // clean all transaction relation with this employee after resign date
                if($model->getRawOriginal('resign_date')){
                    $this->clearRelationTransaction($model);
                }
                // tidak jadi resign
                if(empty($model->getRawOriginal('resign_date'))){
                    $this->restoreRelationTransaction($model);
                }
            }

            if($oldData->getRawOriginal('salary_group_id') != $model->getRawOriginal('salary_group_id')){
                // clean all transaction relation with this employee after resign date
                if($model->getRawOriginal('salary_group_id')){
                    $this->updateSalaryBenefit($model);
                }
            }
            

            if($input['contract_id']){
                if($oldData->contract_id != $input['contract_id']){
                    // set unused old contract id
                    $this->updateContract($input['contract_id']);
                    if(!empty($oldData->contract_id)){
                        $this->updateContract($oldData->contract_id, 0);
                    }                    
                }
            }else{
                // set unused old contract id
                if($oldData->contract_id){
                    $this->updateContract($oldData->contract_id, 0);
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

    private function restoreRelationTransaction($model){
        Attendance::where(['employee_id' => $model->id])
            // ->where('attendance_date','>=', $model->getRawOriginal('resign_date'))
            ->restore();
        Workshift::where(['employee_id' => $model->id])
            // ->where('work_date','>=', $model->getRawOriginal('resign_date'))
            ->restore();
        Payroll::where(['employee_id' => $model->id])
            // ->whereHas('payrollPeriod', function($q) use ($model) {
            //     return $q->where('start_period','>=', $model->getRawOriginal('resign_date'));
            // })
            ->restore();
    }

    private function updateSalaryBenefit($model){
        $oldBenefit = $model->salaryBenefits->keyBy('component_id');
        $newBenefit = SalaryGroupDetail::where(['salary_group_id' => $model->getRawOriginal('salary_group_id')])->get()->keyBy('component_id');
        $deletedKeys = array_diff($oldBenefit->keys()->toArray(),$newBenefit->keys()->toArray());  
        $insertKeys = array_diff($newBenefit->keys()->toArray(),$oldBenefit->keys()->toArray());                
        
        if($deletedKeys){
            SalaryBenefit::where(['employee_id' => $model->id])->whereIn('component_id', $deletedKeys)->forceDelete();            
        }

        if($insertKeys){
            foreach($insertKeys as $key){                                
                $insertBenefit = ['employee_id' => $model->id, 'component_id' => $key, 'benefit_value' => $newBenefit[$key]->component_value];
                SalaryBenefit::create($insertBenefit);                
            }
        }
    }

    private function createSalaryBenefit($model){        
        $newBenefit = SalaryGroupDetail::where(['salary_group_id' => $model->salary_group_id])->get();
        
        foreach($newBenefit as $item){                                
            $insertBenefit = ['employee_id' => $model->id, 'component_id' => $item->component_id, 'benefit_value' => $item->component_value];
            SalaryBenefit::create($insertBenefit);                
        }
        
    }
}
