<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Employee;
use App\Repositories\BaseRepository;

/**
 * Class EmployeeRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class EmployeeShiftmentGroupRepository extends BaseRepository
{    
    protected $lookupColumnSelect = ['id' => 'id', 'text' => 'full_name'];
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

    
    public function paginate($perPage, $currentPage = 1, $columns = ['*'], $search = [])
    {
        $query = $this->allQuery();
        if (!empty($search)) {
            $query->search($search['keyword'], $search['column']);
        }
        $columns[] = 'code';
        $dataPaging = $query->simplePaginate($perPage, $columns, 'page', $currentPage);
        $dataPaging->getCollection()->map(function($item){            
            return $item['text'] = $item['text'].' ( '.$item['code'].' )';
        })->toArray();
        return $dataPaging;
    }
}
