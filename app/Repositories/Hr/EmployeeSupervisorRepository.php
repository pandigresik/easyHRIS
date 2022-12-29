<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Employee;
use App\Repositories\BaseRepository;

/**
 * Class EmployeeRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class EmployeeSupervisorRepository extends BaseRepository
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
            $this->model->whereIn('id', $input['employee'])->update(['supervisor_id' => $input['supervisor_id']]);        
            $this->model->getConnection()->commit();
        } catch (\Exception $e) {            
            $this->model->getConnection()->rollBack();

            return $e;
        }

        return $this->model;
    }

    public function list($filter){
        $singleValues = ['department_id', 'company_id'];        
        $filterData = [];
        $filterArrayData = [];
        foreach($filter as $index => $val){
            if(in_array($index, $singleValues)){
                $filterData[$index] = $val;
            }else{
                $filterArrayData[$index] = $val;
            }
        }
        
        $query = (new Employee())->with(['joblevel', 'jobtitle', 'department', 'businessUnit'])->newQuery();
        if($filterData){
            $query->where($filterData);
        }
        if($filterArrayData){
            foreach($filterArrayData as $index => $val){
                $query->whereIn($index, $val);
            }            
        }
        return $query->get();
    }
    
}
