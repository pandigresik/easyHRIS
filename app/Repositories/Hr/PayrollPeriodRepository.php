<?php

namespace App\Repositories\Hr;

use App\Library\SalaryComponent\Component;
use App\Library\SalaryComponent\DoubleRitase;
use App\Library\SalaryComponent\DoubleSalary;
use App\Library\SalaryComponent\GajiPokokHarian;
use App\Library\SalaryComponent\Kilometer;
use App\Library\SalaryComponent\Overtime;
use App\Library\SalaryComponent\PotonganKehadiran;
use App\Library\SalaryComponent\PremiKehadiran;
use App\Library\SalaryComponent\UangMakan;
use App\Library\SalaryComponent\UangMakanLemburMinggu;
use App\Library\SalaryComponent\UangMakanLuarKota;
use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceSummary;
use App\Models\Hr\Employee;
use App\Models\Hr\Holiday;
use App\Models\Hr\Overtime as HrOvertime;
use App\Models\Hr\Payroll;
use App\Models\Hr\PayrollDetail;
use App\Models\Hr\PayrollPeriod;
use App\Models\Hr\RitaseDriver;
use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

/**
 * Class PayrollPeriodRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 3:14 pm WIB
*/

class PayrollPeriodRepository extends BaseRepository
{
    protected $payrollPeriod;
    protected $bpjsFee;
    private $ritaseEmployee; // untuk hitung tunjangan km dan double rit
    private $summaryAttendanceEmployee; // untuk hitung premi kehadiran
    private $luarKotaEmployee; // hitung uang makan luar kota dan double salary
    private $overtimeEmployee; // hitung uang makan dan tunjangan minggu
    private $attendanceEmployee; // untuk hitung potongan kehadiran
        
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'name',
        'year',
        'month',
        'start_period',
        'end_period',
        'closed'
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
        return PayrollPeriod::class;
    }

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

    private function calculatePayroll($companyId, $period, $payrollPeriod, $employeeId = []){
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
        $workDayEmployee = Workshift::selectRaw('employee_id, count(*) as workday')
                ->whereIn('employee_id', $employees->pluck('id')->toArray())
                ->whereBetween('work_date', [$period['start_period'], $period['end_period']])
                ->groupBy('employee_id')
                ->get()
                ->pluck('workday', 'employee_id')->toArray();
        
        $holidayNotSunday = $this->getHoliday($period['start_period'], $period['end_period']);
        $listEmployees = $employees->pluck('id','id');
        \Log::error($listEmployees);
        $this->setRitaseEmployee(RitaseDriver::whereIn('employee_id', $listEmployees)->whereBetween('work_date',[$period['start_period'], $period['end_period']])->get()->groupBy('employee_id'));
        
        $this->setSummaryAttendanceEmployee(NULL);
        $startDateObj->endOfMonth();
        if($startDateObj->format('Y-m-d') == $period['end_period']){
            $this->setSummaryAttendanceEmployee(AttendanceSummary::where(['year' => $startDateObj->format('Y'), 'month' => $startDateObj->format('m')])->whereIn('employee_id', $listEmployees)->keyBy('employee_id'));
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

    private function calculateEmployeePayroll($workDayCount, $employee, $periodPayroll){          
        $details = [];
        $takeHomePay = 0;
        foreach($employee->salaryBenefits as $benefit){
            if($benefit->component->fixed){
                $tmp = [
                    'benefit_value' => $benefit->getRawOriginal('benefit_value'),
                    'component_id' => $benefit->component_id,
                    'sign_value' => $benefit->component->getRawOriginal('state') == 'p' ? 1 : -1, 
                ];
            }else{
                $tmp = [
                    'benefit_value' => $this->calculateComponent($workDayCount, $employee->id, $benefit->getRawOriginal('benefit_value'), $benefit->component->code),
                    'component_id' => $benefit->component_id,
                    'sign_value' => $benefit->component->getRawOriginal('state') == 'p' ? 1 : -1, 
                ];
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

    private function calculateComponent($workDayCount, $employeeId, $value, $code){
        $result = $value;
        $componentObj = null;
        switch($code){
            case 'TDGJ':
                $doubleRitaseCount = 0; // nanti cari data ritase berdasarkan employeeId                
                $componentObj = new DoubleRitase($doubleRitaseCount, $value);
                break;
            case 'TDDRT':
                $doubleSalary = 0; // nanti cari data ritase berdasarkan employeeId                
                $componentObj = new DoubleSalary($doubleSalary, $value);
                break;
            case 'GPH':                
                $componentObj = new GajiPokokHarian($workDayCount, $value);
                break;
            case 'TDKM':
                $kmCount = 0; // nanti cari data ritase berdasarkan employeeId                
                $componentObj = new Kilometer($kmCount, $value);
                break;
            case 'OT':
                $overtimeCount = 0; // nanti cari data ritase berdasarkan employeeId                
                $componentObj = new Overtime($overtimeCount, $value);
                break;
            case 'PTHD':
                $amountHour = 0;
                $amountDay = 0;            
                $componentObj = new PotonganKehadiran($amountHour, $amountDay, $value);
                break;
            case 'PRHD':                 
                $absentCount = 0;
                $offCount = 0;
                $componentObj = new PremiKehadiran($workDayCount, $value, $absentCount, $offCount);
                break;
            case 'UM':                
                $componentObj = new UangMakan($workDayCount, $value);
                break;
            case 'TUMLM':                
                $componentObj = new UangMakanLemburMinggu($workDayCount, $value);
                break;
            case 'TDUM':                
                $componentObj = new UangMakanLuarKota($workDayCount, $value);
                break;
            default:
        }
        if($componentObj instanceof Component){
            $result = $componentObj->calculate();
        }
        return $result;
    }

    /** jika endDate melewati endOfMonth dari startDate maka split berdasarkan bulannya */
    private function splitPeriod($rangePeriod){
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

    private function getHoliday($startDate, $endDate){
        $result = 0;
        $holiday = Holiday::select(['holiday_date'])->whereBetween('holiday_date', [$startDate, $endDate])->get();
        if(!$holiday->isEmpty()){
            foreach($holiday as $day){
                if(Carbon::parse($day->getRawOriginal('holiday_date'))->dayOfWeek !== Carbon::SUNDAY ){
                    $result += 1;
                }
            }
        }
        return $result;
    }

    /**
     * Get the value of payrollPeriod
     */ 
    public function getPayrollPeriod()
    {
        return $this->payrollPeriod;
    }

    /**
     * Set the value of payrollPeriod
     *
     * @return  self
     */ 
    public function setPayrollPeriod($payrollPeriod)
    {
        $this->payrollPeriod = $payrollPeriod;

        return $this;
    }

    /**
     * Get the value of bpjsFee
     */ 
    public function getBpjsFee()
    {
        return $this->bpjsFee;
    }

    /**
     * Set the value of bpjsFee
     *
     * @return  self
     */ 
    public function setBpjsFee($bpjsFee)
    {
        $this->bpjsFee = $bpjsFee;

        return $this;
    }

    /**
     * Get the value of ritaseEmployee
     */ 
    public function getRitaseEmployee($employeeId = null)
    {
        return empty($employeeId) ? $this->ritaseEmployee : ($this->ritaseEmployee[$employeeId] ?? null);
    }

    /**
     * Set the value of ritaseEmployee
     *
     * @return  self
     */ 
    public function setRitaseEmployee($ritaseEmployee)
    {
        $this->ritaseEmployee = $ritaseEmployee;

        return $this;
    }

    /**
     * Get the value of summaryAttendanceEmployee
     */ 
    public function getSummaryAttendanceEmployee($employeeId = null)
    {
        return empty($employeeId) ? $this->summaryAttendanceEmployee : ($this->summaryAttendanceEmployee[$employeeId] ?? null);
    }

    /**
     * Set the value of summaryAttendanceEmployee
     *
     * @return  self
     */ 
    public function setSummaryAttendanceEmployee($summaryAttendanceEmployee)
    {
        $this->summaryAttendanceEmployee = $summaryAttendanceEmployee;

        return $this;
    }

    /**
     * Get the value of luarKotaEmployee
     */ 
    public function getLuarKotaEmployee($employeeId = null)
    {
        return empty($employeeId) ? $this->luarKotaEmployee : ($this->luarKotaEmployee[$employeeId] ?? null);
    }

    /**
     * Set the value of luarKotaEmployee
     *
     * @return  self
     */ 
    public function setLuarKotaEmployee($luarKotaEmployee)
    {
        $this->luarKotaEmployee = $luarKotaEmployee;

        return $this;
    }

    /**
     * Get the value of overtimeEmployee
     */ 
    public function getOvertimeEmployee($employeeId = null)
    {
        return empty($employeeId) ? $this->overtimeEmployee : ($this->overtimeEmployee[$employeeId] ?? null); 
    }

    /**
     * Set the value of overtimeEmployee
     *
     * @return  self
     */ 
    public function setOvertimeEmployee($overtimeEmployee)
    {
        $this->overtimeEmployee = $overtimeEmployee;

        return $this;
    }

    /**
     * Get the value of attendanceEmployee
     */ 
    public function getAttendanceEmployee($employeeId = null)
    {
        return empty($employeeId) ? $this->attendanceEmployee : $this->attendanceEmployee[$employeeId] ?? null;
    }

    /**
     * Set the value of attendanceEmployee
     *
     * @return  self
     */ 
    public function setAttendanceEmployee($attendanceEmployee)
    {
        $this->attendanceEmployee = $attendanceEmployee;

        return $this;
    }
}
