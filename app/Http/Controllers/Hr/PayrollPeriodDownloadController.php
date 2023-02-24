<?php

namespace App\Http\Controllers\Hr;

use App\Exports\DetailPayrollExport;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollPeriod;
use App\Models\Hr\SalaryComponent;

class PayrollPeriodDownloadController extends AppBaseController
{    
    
    public function exportExcel($id)
    {
        $collection = Payroll::with(['payrollDetails', 'employee' => function($q){
            return $q->select(['id', 'code', 'full_name', 'account_bank','employee_status','department_id', 'jobtitle_id', 'business_unit_id', 'joblevel_id'])
                ->with(['jobtitle', 'department', 'businessUnit','groupPayrollEmployeeReport']);
        }])->where(['payroll_period_id' => $id])        
        ->get()->sortBy('employee.code')->groupBy('employee.groupPayrollEmployeeReport.grouping_payroll_entity_id');
        
        $salaryComponent = SalaryComponent::pluck('id','code');        
        $payrollPeriod = PayrollPeriod::with(['payrollPeriodGroup'])->find($id);
        $fileName = $payrollPeriod->name;
        // return view('exports.payrolls',['payrolls' => $collection, 'component' => $salaryComponent]);
        return (new DetailPayrollExport($collection, $salaryComponent, $payrollPeriod))->download($fileName.'.xlsx');
    }

}
