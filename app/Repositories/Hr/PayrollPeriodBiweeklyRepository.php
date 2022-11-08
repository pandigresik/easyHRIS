<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceSummary;
use App\Models\Hr\Employee;
use App\Models\Hr\Overtime as HrOvertime;
use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollDetail;
use App\Models\Hr\PayrollPeriod;
use App\Models\Hr\RitaseDriver;
use App\Models\Hr\Workshift;
use Carbon\Carbon;

/**
 * Class PayrollPeriodRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 3:14 pm WIB
*/

class PayrollPeriodBiweeklyRepository extends PayrollPeriodRepository
{
    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        
        try {
            $periods = $this->splitPeriod($input['range_period']);
            $employeeId = $input['employee_id'] ?? [];
            $bpjsFee = $input['bpjs_fee'] ?? [];
            $payrollPeriodGroupId = $input['payroll_period_group_id'] ?? NULL;
            $this->setBpjsFee($bpjsFee);                        
            foreach($periods as $_index => $period){                
                $this->calculatePayroll($input['company_id'], $period, $payrollPeriodGroupId, $employeeId);
                if($_index){
                    // jika dibagi menjadi 2 periode, maka set null potongan Bpjs periode yang kedua
                    $this->setBpjsFee([]);
                }
            }
            $this->model->getConnection()->commit();            
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    protected function calculatePayroll($companyId, $period, $payrollPeriod, $employeeId = []){
        // create payrollPeriod if not exists
        $startDateObj = Carbon::parse($period['start_period']);
        $period['company_id'] = $companyId;
        $period['payroll_period_group_id'] = $payrollPeriod;
        $period['year'] = $startDateObj->format('Y');
        $period['month'] = $startDateObj->format('m'); 
        $period['name'] = 'Periode gaji '. localFormatDate($period['start_period']).' sd '.localFormatDate($period['end_period']);
        $periodPayroll = PayrollPeriod::firstOrCreate($period);
        
        // get list employee
        $employeeOjb = Employee::select(['id', 'code'])->with(['salaryBenefits' => function($q){
            $q->with(['component']);
        }])->where(['payroll_period_group_id' => $payrollPeriod]);

        if(!empty($employeeId)){
            $employeeOjb->whereIn('id', $employeeId);
        }

        $employees = $employeeOjb->get();
        $listEmployees = $employees->pluck('id')->toArray();
        $workDayEmployee = Workshift::selectRaw('employee_id, count(*) as workday')
                ->whereIn('employee_id', $listEmployees)
                ->whereBetween('work_date', [$period['start_period'], $period['end_period']])
                ->groupBy('employee_id')
                ->get()
                ->pluck('workday', 'employee_id')->toArray();
        
        $holidayNotSunday = $this->getHoliday($period['start_period'], $period['end_period']);
        // ambil semua data component yang mempengaruhi gaji        
        $ritaseDrivers = RitaseDriver::whereIn('employee_id', $listEmployees)->whereBetween('work_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id');
        $this->setRitaseEmployee($ritaseDrivers);        
        $this->setSummaryAttendanceEmployee([]);
        
        if($periodPayroll->isEndOfMonth()){
            $this->setSummaryAttendanceEmployee(AttendanceSummary::where(['year' => $startDateObj->format('Y'), 'month' => $startDateObj->format('m')])->whereIn('employee_id', $listEmployees)->get()->keyBy('employee_id'));
        }
        
        $this->setLuarKotaEmployee(Attendance::luarKota()->whereIn('employee_id', $listEmployees)->whereBetween('attendance_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        $this->setOvertimeEmployee(HrOvertime::whereIn('employee_id', $listEmployees)->whereBetween('overtime_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        $this->setAttendanceEmployee(Attendance::absentLeaveLate()->whereIn('employee_id', $listEmployees)->whereBetween('attendance_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        
        foreach($employees as $employee){
            $workDayCount = $workDayEmployee[$employee->id] ?? 0;
            if(in_array($this->getPayrollPeriod(), ['weekly', 'biweekly'])){
                $workDayCount += $holidayNotSunday;
            }
            $this->calculateEmployeePayroll($workDayCount, $employee, $periodPayroll);
        }
        (new PayrollDetail())->flushCache();
    }

    protected function calculateEmployeePayroll($workDayCount, $employee, $periodPayroll){          
        $details = [];
        $takeHomePay = 0;
        foreach($employee->salaryBenefits as $benefit){
            $tmp = [
                'component_id' => $benefit->component_id,
                'sign_value' => $benefit->component->getRawOriginal('state') == 'p' ? 1 : -1, 
                'benefit_value' => 0
            ];
            
            /** untuk tunjangan jabatan hanya diberikan di akhir bulan saja */
            if( in_array($benefit->component->getRawOriginal('code') , config('local.benefit_end_of_month'))){
                if(!$periodPayroll->isEndOfMonth()){
                    $tmp['benefit_value'] = 0;
                }                
            }else{
                if($benefit->component->fixed){
                    $tmp['benefit_value'] = $benefit->getRawOriginal('benefit_value');                
                }else{
                    $tmp['benefit_value'] = $this->calculateComponent($workDayCount, $employee->id, $benefit->getRawOriginal('benefit_value'), $benefit->component->code);                
                }
            }

            /** jika tidak ada dalam list potongan bpjs yang dipilih maka set 0 */
            if(in_array($periodPayroll->payrollPeriodGroup->getRawOriginal('type_period'), ['weekly', 'biweekly'])){
                $listBpjsFee = config('local.bpjs_fee');
                if(in_array($tmp['component_id'], $listBpjsFee)){
                    if(!in_array($tmp['component_id'], $this->getBpjsFee())){                        
                        $tmp['benefit_value'] = 0;
                    }
                }
            }

            $takeHomePay += ($tmp['sign_value'] * $tmp['benefit_value']);
            $details[] = $tmp;            
        }
        
        $payroll = Payroll::firstOrNew([
            'payroll_period_id' => $periodPayroll->id,
            'employee_id' => $employee->id
        ]);
        $payroll->take_home_pay = $takeHomePay < 0 ? 0 : $takeHomePay;
        $payroll->save();
        $userId = \Auth::id();
        foreach($details as $detail){            
            $detail['payroll_id'] = $payroll->id;
            $detail['created_by'] = $userId;
            PayrollDetail::upsert($detail, ['payroll_id', 'component_id']);            
        }        
    }
    
    /** jika endDate melewati endOfMonth dari startDate maka split berdasarkan bulannya */
    protected function splitPeriod($rangePeriod){
        $resultPeriod = [];
        $period = generatePeriod($rangePeriod);
        $startDate = $period['startDate'];
        $endOfMonthStartDate = Carbon::parse($startDate)->endOfMonth()->format('Y-m-d');
        $endDate = $period['endDate'];

        if($endDate > $endOfMonthStartDate){
            $resultPeriod[] = ['start_period' => $startDate, 'end_period' => $endOfMonthStartDate];
            $resultPeriod[] = ['start_period' => substr($endDate, 0, 7).'-01' , 'end_period' => $endDate];
        }else{
            $resultPeriod[] = ['start_period' => $startDate, 'end_period' => $endDate];
        }
        return $resultPeriod;
    }
}
