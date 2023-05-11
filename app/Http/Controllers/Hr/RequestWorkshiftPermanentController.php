<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\AttendanceReportRepository;

use App\Http\Controllers\AppBaseController;
use App\Models\Hr\Employee;
use App\Repositories\Hr\GroupingPayrollEntityRepository;
use App\Repositories\Hr\PayrollPeriodGroupRepository;
use Illuminate\Http\Request;

class RequestWorkshiftPermanentController extends AppBaseController
{
    /** @var  AttendanceReportRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = AttendanceReportRepository::class;
    }

    public function index(Request $request)
    {        
        if ($request->ajax()) {            
            $period = generatePeriodFromString($request->get('period'));
            $grouping = $request->get('grouping');
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $groupingPayrollReport = $request->get('grouping_payroll_entity_id');
            $employeeFilter =  $request->get('employee_id');
            $payrollGroup = $request->get('payroll_group_period_id');
            $filterData = [
                'startDate' => $startDate->format('Y-m-d'), 
                'endDate' => $endDate->format('Y-m-d'),                 
                'employeeFilter' => $employeeFilter,
                'payrollGroup' => $payrollGroup,
                'grouping' => $grouping,
                'groupingPayrollReport' => $groupingPayrollReport
            ];
            $datas = $this->getRepositoryObj()->list($filterData);
            $view = 'list_date';
            $employees = [];
            if($grouping == 'employee'){
                $view = 'list_employee';
                $employees = Employee::select(['code','id','full_name'])->whereIn('id', $datas->pluck('employee_id'))->get()->keyBy('id');
            }            

            return view('hr.request_workshift_permanent.'.$view)
                ->with([
                    'datas' => $datas, 
                    'startDate' => $startDate->format('Y-m-d'), 
                    'endDate' => $endDate->format('Y-m-d'),                    
                    'employees' => $employees,
                    'payrollGroup' => $payrollGroup                                        
                ]);
        }

        return view('hr.request_workshift_permanent.index')->with($this->getOptionItems());
    }    

    private function getOptionItems()
    {        
        $payrollGroup = new PayrollPeriodGroupRepository();
        $groupingPayrollEntity = new GroupingPayrollEntityRepository();
        return [
            'payrollGroupItems' => ['' => __('crud.option.fingerprintDevice_placeholder')] + $payrollGroup->pluck(),            
            'groupingPayrollEntityItems' => ['' => __('crud.option.fingerprintDevice_placeholder')] + $groupingPayrollEntity->pluck(),
        ];
    }
}
