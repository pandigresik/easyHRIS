<?php

namespace App\Repositories\Hr;

use App\Models\Base\Setting;
use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceSummary;
use App\Models\Hr\Employee;
use App\Models\Hr\Overtime as HrOvertime;
use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollDetail;
use App\Models\Hr\PayrollPeriod;
use App\Models\Hr\Workshift;
use Carbon\Carbon;

/**
 * Class PayrollPeriodRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 3:14 pm WIB
*/

class PayrollPeriodMonthlyRepository extends PayrollPeriodRepository
{
    private $defaultHariKerja = 25;
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
            $employeeId = $input['employee_id'] ?? [];            
            $payrollPeriodGroupId = $input['payroll_period_group_id'] ?? NULL;
            $period = generatePeriod($input['range_period']);
            $period['start_period'] = $period['startDate'];
            $period['end_period'] = $period['endDate'];
            $this->setStartPeriodPayroll($period['start_period']);
            $this->setEndPeriodPayroll($period['end_period']);
            unset($period['startDate']);
            unset($period['endDate']);
            $this->calculatePayroll($input['company_id'], $period, $payrollPeriodGroupId, $employeeId);
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
        $setting = Setting::where(['type' => 'payroll'])->get()->keyBy('name');
        $minMonthGetMealAllowance = $setting['get_meal_allowance_month']->value ?? 3;
        $minJoinDateMealAllowance = Carbon::parse($period['start_period'])->subMonths($minMonthGetMealAllowance)->format('Y-m-d');
        $maxJoinDateMealAllowance = Carbon::parse($period['end_period'])->subMonths($minMonthGetMealAllowance)->format('Y-m-d');
        // get list employee
        $employeeOjb = Employee::select(['id', 'code', 'join_date', 'resign_date'])->with(['salaryBenefits' => function($q){
            $q->with(['component']);
        }])->where(['payroll_period_group_id' => $payrollPeriod]);

        if(!empty($employeeId)){
            $employeeOjb->whereIn('id', $employeeId);
        }

        $employees = $employeeOjb->get();
        
        $listEmployees = $employees->pluck('id')->toArray();
        $workDayEmployee = Attendance::selectRaw('employee_id, count(*) as workday')
                ->whereIn('employee_id', $listEmployees)
                ->whereBetween('attendance_date', [$period['start_period'], $period['end_period']])
                ->whereNotIn('shiftment_id', config('local.shiftment_off'))
                ->whereNotIn('state', config('local.exclude_meal_allowance'))                
                ->groupBy('employee_id')
                ->get()
                ->pluck('workday', 'employee_id')->toArray();
        
        $this->setSummaryAttendanceEmployee([]);
        $this->setPremiPeriod($periodPayroll->getRawOriginal('year').'-'.$periodPayroll->getRawOriginal('month'));
        
        $this->setSummaryAttendanceEmployee(AttendanceSummary::where(['year' => $startDateObj->format('Y'), 'month' => intval($startDateObj->format('m'))])->whereIn('employee_id', $listEmployees)->get()->groupBy('employee_id'));
                
        //$this->setLuarKotaEmployee(Attendance::luarKota()->whereIn('employee_id', $listEmployees)->whereBetween('attendance_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        $this->setOvertimeEmployee(HrOvertime::whereIn('employee_id', $listEmployees)->approve()->whereBetween('overtime_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        $this->setAbsentLateEmployee(Attendance::absentLeaveLate()->whereIn('employee_id', $listEmployees)->whereBetween('attendance_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        
        foreach($employees as $employee){
            $workDayCount = $workDayEmployee[$employee->id] ?? 0;
            $employee->checkMealAllowance($minJoinDateMealAllowance, $maxJoinDateMealAllowance, $minMonthGetMealAllowance);
            $this->calculateEmployeePayroll($workDayCount, $employee, $periodPayroll);
        }
        (new PayrollDetail())->flushCache();
    }

    protected function calculateEmployeePayroll($workDayCount, $employee, $periodPayroll){          
        $details = [];
        $takeHomePay = 0;
        $overtimeSalary = 0;
        $dailySalary = 0;        
        foreach($employee->salaryBenefits as $benefit){
            if($benefit->component->getRawOriginal('code') == 'GP'){
                $dailySalary = $benefit->getRawOriginal('benefit_value') / $this->defaultHariKerja;
            }
            if($benefit->component->getRawOriginal('code') == 'OT'){
                $overtimeSalary = $benefit->getRawOriginal('benefit_value');
            }
            
            $tmp = [
                'component_id' => $benefit->component_id,
                'sign_value' => $benefit->component->getRawOriginal('state') == 'p' ? 1 : -1, 
                'benefit_value' => 0
            ];
            
            if($benefit->component->fixed){
                $tmp['benefit_value'] = $benefit->getRawOriginal('benefit_value');
                
                if($employee->getRawOriginal('join_date') > $periodPayroll->getRawOriginal('start_period')){                    
                    if(in_array($benefit->component->code, ['GP'])){
                        /** khusus untuk GP, jika join date > start_date maka, GP / 25 * hari kerja */
                        /** uang makan dibayarkan minimal kerja 4 jam, cek yang statusnya PC atau DT */
                        $startOfMonthPeriod = Carbon::parse($periodPayroll->getRawOriginal('end_period'))->startOfMonth();
                        $endOfMonthPeriod = Carbon::parse($periodPayroll->getRawOriginal('end_period'))->endOfMonth();
                        $startPeriodObj = Carbon::parse($employee->getRawOriginal('join_date'));
                        // jika masuk tgl 01 maka gajinya utuh
                        if($startPeriodObj > $startOfMonthPeriod){
                            $workDayCount = $startPeriodObj->diffInDays($endOfMonthPeriod) + 1;
                            $sundayDay = $startPeriodObj->diffInDaysFiltered(function (Carbon $date){
                                return $date->dayOfWeek == Carbon::SUNDAY;         
                            }, $endOfMonthPeriod->addDay());
                            
                            $workDayCount -= $sundayDay;                                                    
                                if($workDayCount < 25){
                                    $tmp['benefit_value'] = ($benefit->getRawOriginal('benefit_value') / 25) * $workDayCount;
                                }                            
                            
                        }
                    }
                    
                    
                }
                
            }else{                                
                $tmp['benefit_value'] = $this->calculateComponent($workDayCount, $employee, $benefit->getRawOriginal('benefit_value'), $benefit->component->code);
            }            

            $takeHomePay += ($tmp['sign_value'] * $tmp['benefit_value']);
            $details[] = $tmp;            
        }
        
        $payroll = Payroll::firstOrNew([
            'payroll_period_id' => $periodPayroll->id,
            'employee_id' => $employee->id
        ]);
        
        $amountLateMinute = $this->getAbsentLateEmployee($employee->id)->sum(function($item){
            return $item->getRawOriginal('late_in') + $item->getRawOriginal('early_out');
        });
        $absentCodeNotPay = config('local.absent_code_not_pay');
        // jika non staff maka sakit dengan surat dokter tetap dipotong
        if($employee->grade == 'NON-STAFF'){
            $absentCodeNotPay[] = 'SKT';
        }
        $amountAbsentDay = $this->getAbsentLateEmployee($employee->id)->whereIn('state', $absentCodeNotPay)->count();
        
        $payroll->take_home_pay = $takeHomePay < 0 ? 0 : $takeHomePay;
        $payroll->additional_info = [
            'workday' => $workDayCount,
            'dailySalary' => $dailySalary,                        
            'overtimeSalary' => $overtimeSalary,            
            'overtime' => $this->getOvertimeEmployee($employee->id)->sum(function($item){                    
                        return $item->getRawOriginal('payroll_calculated_value');
                    }),
            'late_early'=> $amountLateMinute,
            'absent' => $amountAbsentDay
        ];
        $payroll->save();
        $userId = \Auth::id();
        $updateData = [];
        foreach($details as $detail){                        
            $detail['payroll_id'] = $payroll->id;
            $detail['created_by'] = $userId;
            $updateData[] = $detail;            
        }        
        PayrollDetail::upsert($updateData, ['payroll_id', 'component_id']);            
    }    
}
