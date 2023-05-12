<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Repositories\BaseRepository;

/**
 * Class AttendanceRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 8:16 am WIB
*/

class AttendanceReportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',        
        'reason_id',
        'attendance_date'        
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
        return Attendance::class;
    }

    public function list($filterData = []){
        $startDate = $filterData['startDate'];
        $endDate = $filterData['endDate'];
        $employeeFilter = $filterData['employeeFilter'];
        $payrollGroup = $filterData['payrollGroup'];
        $groupingPayrollReport = $filterData['groupingPayrollReport'];
        $grouping = $filterData['grouping'];
        $datas = Attendance::employeeDescendants()->disableModelCaching()->whereBetween('attendance_date', [$startDate, $endDate])->groupBy('state')->newQuery(); 
        switch($grouping){
            case 'employee':
                $datas->selectRaw('count(*) as total, state, employee_id, employees.code')
                    ->join('employees', 'employees.id','=','attendances.employee_id')
                    // ->orderBy('cast(employees.code as unsigned)')
                    ->orderBy('employee_id')
                    ->groupBy('employee_id')
                    ->groupBy('employees.code');
                break;
            case 'date':
                $datas->selectRaw('count(*) as total, state, attendance_date')->groupBy('attendance_date');
                break;
        }
        
        if($groupingPayrollReport){
            $datas = $datas->whereIn('employee_id', function($q) use ($groupingPayrollReport){
                return $q->select(['employee_id'])->from('grouping_payroll_employee_report')->where(['grouping_payroll_entity_id' => $groupingPayrollReport]);
            });
        }

        if($employeeFilter){
            $datas->whereIn('employee_id', $employeeFilter);
        }

        if($payrollGroup){
            $datas = $datas->whereIn('employee_id', function($q) use ($payrollGroup){
                return $q->select(['id'])->from('employees')->where(['payroll_period_group_id' => $payrollGroup]);
            });
        }
        return $datas->get();
    }
}
