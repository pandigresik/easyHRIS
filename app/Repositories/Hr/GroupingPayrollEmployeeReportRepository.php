<?php

namespace App\Repositories\Hr;

use App\Models\Hr\GroupingPayrollEmployeeReport;
use App\Models\Hr\GroupingPayrollEntity;
use App\Repositories\BaseRepository;

/**
 * Class GroupingPayrollEmployeeReportRepository
 * @package App\Repositories\Hr
 * @version November 18, 2022, 9:50 am WIB
*/

class GroupingPayrollEmployeeReportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'grouping_payroll_entity_id'
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
        return GroupingPayrollEmployeeReport::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $employees = $input['employee_id'] ?? [];
            
            foreach($employees as $employee){
                GroupingPayrollEmployeeReport::create([
                    'grouping_payroll_entity_id' => $input['grouping_payroll_entity_id'],
                    'employee_id' => $employee                    
                ]);
            }
            
            $this->model->getConnection()->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }
}
