<?php

namespace App\Repositories\Hr;

use App\Library\SalaryComponent\Component;
use App\Library\SalaryComponent\DoubleRitase;
use App\Library\SalaryComponent\DoubleSalary;
use App\Library\SalaryComponent\GajiPokokHarian;
use App\Library\SalaryComponent\Kilometer;
use App\Library\SalaryComponent\SummaryOvertime;
use App\Library\SalaryComponent\PotonganKehadiran;
use App\Library\SalaryComponent\PremiKehadiran;
use App\Library\SalaryComponent\TunjanganJabatanHarian;
use App\Library\SalaryComponent\TunjanganMasukHariLibur;
use App\Library\SalaryComponent\UangMakan;
use App\Library\SalaryComponent\UangMakanLembur;
use App\Library\SalaryComponent\UangMakanLemburMinggu;
use App\Library\SalaryComponent\UangMakanLuarKota;
use App\Models\Hr\Holiday;
use App\Models\Hr\PayrollPeriod;
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
    protected $ritaseEmployee; // untuk hitung tunjangan km dan double rit
    protected $summaryAttendanceEmployee; // untuk hitung premi kehadiran
    protected $luarKotaEmployee; // hitung uang makan luar kota dan double salary
    protected $overtimeEmployee; // hitung uang makan dan tunjangan minggu
    protected $absentLateEmployee; // untuk hitung potongan kehadiran
    private $premiPeriod; // untuk hitung premi kehadiran
    private $startPeriodPayroll;
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

    protected function calculateComponent($workDayCount, $employee, $value, $code){
        $result = $value;
        $componentObj = null;
        $employeeId = $employee->id;        
        switch($code){
            case 'TDDRT':
                $doubleRitaseCount = $this->getRitaseEmployee($employeeId)->sum(function($item){
                    return $item->getRawOriginal('double_rit');
                });
                
                $componentObj = new DoubleRitase($doubleRitaseCount, $value);
                break;
            case 'TDGJ':
                $doubleSalary = $this->getLuarKotaEmployee($employeeId)->count();                
                $componentObj = new DoubleSalary($doubleSalary, $value);
                break;
            case 'GPH':              
                $componentObj = new GajiPokokHarian($workDayCount, $value);
                break;
            case 'TJH':              
                $componentObj = new TunjanganJabatanHarian($workDayCount, $value);
                break;
            case 'TDKM':
                $kmCount = $this->getRitaseEmployee($employeeId)->sum(function($item){
                    return $item->getRawOriginal('km');
                });
                $componentObj = new Kilometer($kmCount, $value);
                break;
            case 'OT':
                $overtimes = $this->getOvertimeEmployee($employeeId)->map(function($item){
                    return $item->getRawOriginal('amount');
                })->toArray();
                $componentObj = new SummaryOvertime($overtimes);
                break;
            // berdasarkan data absensi 
            case 'PTHD':                
                $amountMinute = $this->getAbsentLateEmployee($employeeId)->sum(function($item){
                    return $item->getRawOriginal('late_in') + $item->getRawOriginal('early_out');
                });
                $amountDay = $this->getAbsentLateEmployee($employeeId)->whereIn('state', config('local.absent_code_not_pay'))->count();
                $componentObj = new PotonganKehadiran(minuteToHour($amountMinute), $amountDay, $value);
                break;
            case 'PRHD':
                $joinDate = $employee->getRawOriginal('join_date');
                $resignDate = $employee->getRawOriginal('resign_date');                
                $absentMonthCount = $this->getSummaryAttendanceEmployee($employeeId)->sum('total_absent');
                $workDayMonthCount = 25; // dalam satu bulan default 25 hari                
                if($joinDate > $this->getStartPremiPeriod()){                    
                    $workDayMonthCount = $this->getSummaryAttendanceEmployee($employeeId)->sum('total_workday');
                }                
                if($resignDate){
                    if($resignDate <= $this->getEndPremiPeriod()){
                        $workDayMonthCount = 0;
                    }
                }
                                                
                $offMonthCount = $this->getSummaryAttendanceEmployee($employeeId)->sum('total_off');                
                $componentObj = new PremiKehadiran($workDayMonthCount, $value, $absentMonthCount, $offMonthCount);
                break;
            case 'UM':  
                /** uang makan dibayarkan minimal kerja 4 jam, cek yang statusnya PC atau DT */
                $amountDay = $this->getAbsentLateEmployee($employeeId)->whereIn('state', config('local.leave_code'))->sum(function($item){
                    $workingTime = diffMinute($item->getRawOriginal('check_in_schedule'), $item->getRawOriginal('check_out_schedule'));
                    return ($workingTime - ( $item->getRawOriginal('late_in') + $item->getRawOriginal('early_out') )) >= 240 ? 1 : 0;
                });
                $componentObj = new UangMakan(($workDayCount + $amountDay), $value);
                break;
            case 'UML':
                $overtimes = $this->getOvertimeEmployee($employeeId);
                $componentObj = new UangMakanLembur($overtimes, $value);
                break;
            case 'TMHL':
                $overtimes = $this->getOvertimeEmployee($employeeId);
                $componentObj = new TunjanganMasukHariLibur($overtimes, $value);
                break;
            case 'TUMLM':
                $overtimes = $this->getOvertimeSundayEmployee($employeeId);                              
                $componentObj = new UangMakanLemburMinggu($overtimes, $value);
                break;
            case 'TDUM':      
                $luarKotaCount = $this->getLuarKotaEmployee($employeeId)->count();
                $componentObj = new UangMakanLuarKota($luarKotaCount, $value);
                break;
            default:
        }
        if($componentObj instanceof Component){
            $result = $componentObj->calculate();
        }
        return $result;
    }    

    protected function getHoliday($startDate, $endDate){
        $result = [];
        $holiday = Holiday::select(['holiday_date'])->whereBetween('holiday_date', [$startDate, $endDate])->get();
        if(!$holiday->isEmpty()){
            foreach($holiday as $day){
                if(Carbon::parse($day->getRawOriginal('holiday_date'))->dayOfWeek !== Carbon::SUNDAY ){
                    $result[] = $day->getRawOriginal('holiday_date');
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
        return empty($employeeId) ? $this->ritaseEmployee : ($this->ritaseEmployee[$employeeId] ?? collect([]));
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
        return empty($employeeId) ? $this->summaryAttendanceEmployee : ($this->summaryAttendanceEmployee[$employeeId] ?? collect([]));
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
        return empty($employeeId) ? $this->luarKotaEmployee : ($this->luarKotaEmployee[$employeeId] ?? collect([]));
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
        return empty($employeeId) ? $this->overtimeEmployee : ($this->overtimeEmployee[$employeeId] ?? collect([])); 
    }

    /**
     * Get the value of overtimeEmployee
     */ 
    public function getOvertimeSundayEmployee($employeeId = null)
    {
        $result = [];
        $overtimes = $this->getOvertimeEmployee($employeeId);
        if(!empty($overtimes)){
            if(!$overtimes->isEmpty()){
                foreach($overtimes as $ot){
                    if($ot->isSundayOvertime()){
                        $result[] = minuteToHour($ot->getRawOriginal('calculated_value'));
                    }
                }
            }
        }
        return $result;
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
    public function getAbsentLateEmployee($employeeId = null)
    {
        return empty($employeeId) ? $this->absentLateEmployee : $this->absentLateEmployee[$employeeId] ?? collect([]);
    }

    /**
     * Set the value of attendanceEmployee
     *
     * @return  self
     */ 
    public function setAbsentLateEmployee($absentLateEmployee)
    {
        $this->absentLateEmployee = $absentLateEmployee;

        return $this;
    }

    public function getStartPremiPeriod(){
        return Carbon::createFromFormat('Y-m', $this->premiPeriod)->startOfMonth()->format('Y-m-d');
    }

    public function getEndPremiPeriod(){
        return Carbon::createFromFormat('Y-m', $this->premiPeriod)->endOfMonth()->format('Y-m-d');
    }

    public function setPremiPeriod($premiPeriod){
        $this->premiPeriod = $premiPeriod;
    }



    /**
     * Get the value of startPeriodPayroll
     */ 
    public function getStartPeriodPayroll()
    {
        return $this->startPeriodPayroll;
    }

    /**
     * Set the value of startPeriodPayroll
     *
     * @return  self
     */ 
    public function setStartPeriodPayroll($startPeriodPayroll)
    {
        $this->startPeriodPayroll = $startPeriodPayroll;

        return $this;
    }
}
