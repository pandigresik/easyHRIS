<?php

namespace App\Repositories\Hr;

use App\Library\Formula\OvertimeDay;
use App\Library\SalaryComponent\Overtime as SalaryComponentOvertime;
use App\Models\Base\Setting;
use App\Models\Hr\AbsentReason;
use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\LeaveDetails;
use App\Models\Hr\Overtime;
use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

/**
 * Class AttendanceRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 8:16 am WIB
*/

class AttendanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'reason_id',
        'attendance_date',
        'description',
        'check_in_schedule',
        'check_out_schedule',
        'check_in',
        'check_out',
        'early_in',
        'early_out',
        'late_in',
        'late_out',
        'absent'
    ];
    /** in minutes */
    private $maxCheckout;
    private $minCheckin;
    private $lateinTolerance;

    private $reason;
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


    private function setSettingAttendance(){
        $setting = Setting::where(['type' => 'attendance'])->get()->keyBy('name');
        $this->setMaxCheckout(intval($setting['max_checkout']->value));
        $this->setMinCheckin(intval($setting['min_checkin']->value));
        $this->setLateinTolerance(intval($setting['latein_tolerance']->value));        
    }

    private function setReasonAttendance(){
        $this->setReason(AbsentReason::pluck('code', 'id')->toArray());
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $period = generatePeriod($input['work_date_period']);
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $shiftmentGroup = $input['shiftment_group_id'] ?? [];
            $employeeId = $input['employee_id'] ?? [];
            $this->setSettingAttendance();
            $this->setReasonAttendance();
            $this->processAttendance($startDate, $endDate, $shiftmentGroup, $employeeId);
            $this->model->newInstance()->flushCache();
                        
            $this->model->getConnection()->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        } 
    }

    private function processAttendance($startDate, $endDate, $shiftmentGroup, $employeeId){                
        $attandanceLogs = $this->listAttendanceLog($startDate, $endDate, $shiftmentGroup, $employeeId);
        $workshifts = $this->listWorkshift($startDate, $endDate, $shiftmentGroup, $employeeId);        
        $overtimes = $this->listOvertime($startDate, $endDate, $shiftmentGroup, $employeeId);            
        $leaves = $this->listLeaves($startDate, $endDate, $shiftmentGroup, $employeeId);
        
        foreach($workshifts as $employee => $workshift){            
            $log = $attandanceLogs[$employee] ?? collect([]);
            $overtime = $overtimes[$employee] ?? collect([]); 
            $leave = $leaves[$employee] ?? collect([]);
                        
            $processResult = $this->processEmployeeAttendance($log, $workshift, $overtime, $leave);
            if(!empty($processResult['attendance'])){
                Attendance::upsert($processResult['attendance'], ['employee_id', 'attendance_date']);
            }
            
            if(!empty($processResult['overtime'])){
                foreach($processResult['overtime'] as $ot){                    
                    $ot->save();                    
                }
            }
        }
    }

    private function processEmployeeAttendance($log, $workshift, $overtime, $leave){
        $workshiftDate = $workshift->keyBy(function($item){ return $item->getRawOriginal('work_date');});
        $logDate = $log->groupBy('finger_date');
        
        $overtimeDate = $overtime->groupBy(function($item){ return $item->getRawOriginal('overtime_date');});
        $leaveDate = $leave->keyBy(function($item){ return $item->getRawOriginal('leave_date');});        
        $attendanceResult = [];
        $overtimeResult = [];
        foreach($workshiftDate as $date => $schedule){
            $resignDate = $schedule->employee->getRawOriginal('resign_date');
            if($resignDate){
                if($schedule->getRawOriginal('work_date') >= $resignDate){
                    continue;
                }
            }            
            /** ambil juga data hari berikutnya untuk case shift 2,3 dan lembur */
            $prevDate = Carbon::parse($date)->subDay()->format('Y-m-d');
            $nextDate = Carbon::parse($date)->addDay()->format('Y-m-d');
            $fingerLogData = collect([]);            
            if(isset($logDate[$prevDate])){
                $fingerLogData = $fingerLogData->merge($logDate[$prevDate]);                
            }
            
            if(isset($logDate[$date])){
                $fingerLogData = $fingerLogData->merge($logDate[$date]);                
            }

            if(isset($logDate[$nextDate])){
                $fingerLogData = $fingerLogData->merge($logDate[$nextDate]);                
            }            
            $tmp = [
                'employee_id' => $schedule->employee_id,
                'shiftment_id' => $schedule->shiftment_id,
                'reason_id' => isset($leaveDate[$date]) ? $leaveDate[$date]->reason_id : null,
                'attendance_date' => $schedule->getRawOriginal('work_date'),                
                'check_in_schedule' => $schedule->getRawOriginal('start_hour'),
                'check_out_schedule' => $schedule->getRawOriginal('end_hour'),                                
                'absent' => 1,
                'early_in' => 0,
                'early_out' => 0,
                'late_in' => 0,
                'late_out' => 0, 
                'check_in' => NULL,
                'check_out' => NULL,
                'deleted_at' => NULL,
                'state' => $schedule->isOffShift() ? 'OK' : 'INVALID',
                'created_by' => \Auth::id()
            ];

            if(!empty($tmp['reason_id'])){
                $tmp['state'] = $this->getReason($tmp['reason_id']); 
                if(in_array($tmp['state'], config('local.reason_code_not_absent'))){
                    $tmp['absent'] = 0;
                }
            }
            $overtimeCurrentDate = $overtimeDate[$date] ?? [];
            if(!$fingerLogData->isEmpty()){
                $fingerClassification = $this->getFingerTimeDate($schedule, $fingerLogData, $overtimeCurrentDate);
                
                $tmp['check_in'] = $fingerClassification['checkin'];
                $tmp['check_out'] = $fingerClassification['checkout'];
                
                // dihitung keterlambatan jika bukan hari libur
                if(!is_null($tmp['check_in']) && !isWorkshiftOff($tmp) ){
                    $tmp['early_in'] = $tmp['check_in_schedule'] > $tmp['check_in'] ? diffMinute($tmp['check_in'], $tmp['check_in_schedule']): 0;
                    $tmp['late_in'] = $tmp['check_in'] > $tmp['check_in_schedule'] ? diffMinute($tmp['check_in'], $tmp['check_in_schedule']): 0;
                }
                // dihitung keterlambatan jika bukan hari libur
                if(!is_null($tmp['check_out']) && !isWorkshiftOff($tmp) ){
                    $tmp['early_out'] = $tmp['check_out_schedule'] > $tmp['check_out'] ? diffMinute($tmp['check_out'], $tmp['check_out_schedule']): 0; 
                    $tmp['late_out'] = $tmp['check_out'] > $tmp['check_out_schedule'] ? diffMinute($tmp['check_out'], $tmp['check_out_schedule']): 0;
                }

                if(!is_null($tmp['check_out']) && !is_null($tmp['check_in']) ){                    
                    if($tmp['state'] == 'INVALID'){
                        $lateinTolerance = $this->getLateinTolerance();
                        if($tmp['late_in'] > (0 + $lateinTolerance) ){
                            $tmp['state'] = 'LATEIN';
                        } else if($tmp['early_out'] > 0){
                            $tmp['state'] = 'EARLYOUT';
                        }else{
                            $tmp['state'] = 'OK';
                        }
                    }                    
                }                
                $tmp['absent'] = 0;
                // jika checkin dan checkout null maka set sebagai absent
                if(is_null($tmp['check_out']) && is_null($tmp['check_in']) ){                    
                    if($tmp['state'] == 'INVALID'){
                        $tmp['absent'] = 1;
                        $tmp['state'] = 'ABSENT';
                    }
                }
            }else{
                if($tmp['state'] == 'INVALID'){
                    $tmp['state'] = 'ABSENT';
                }
            }
                      
            $attendanceResult[] = $tmp;
            if(!empty($fingerClassification['overtimes'])){                
                foreach($fingerClassification['overtimes'] as $ot){
                    $amountOvertime = $ot->benefit->getRawOriginal('benefit_value') ?? 0;
                    // not use calculated_value because maybe calculated value formated not as number                    
                    $ot->amount = (new SalaryComponentOvertime(minuteToHour($ot->payroll_calculated_value) , $amountOvertime))->calculate();
                    // unset($ot->raw_calculated_value);
                    $overtimeResult[] = $ot;
                }                
            }
        }
        
        return ['attendance' => $attendanceResult, 'overtime' => $overtimeResult];
    }
    // untuk data attendance tambahhkan h+1 untuk endDate, karena bisa jadi overday misal ketika shift 3 
    // dan h-1 untuk startDate karena bisa jadi jam masuknya 00:00:00 maka bisa jadi datang 30 menit sebelumnya 
    // sehingga masih masuk tanggal sebelumnya
    private function listAttendanceLog($startDate, $endDate, $shiftmentGroup, $employeeId){
        $endDate = Carbon::parse($endDate)->addDay()->format('Y-m-d');
        $startDate = Carbon::parse($startDate)->subDay()->format('Y-m-d');
        $att = AttendanceLogfinger::select(['employee_id', 'fingertime'])->whereBetween('fingertime',[$startDate.' 00:00:00',$endDate.' 23:59:59'])->orderBy('fingertime');
        if(!empty($employeeId)){    
            $att->whereIn('employee_id', $employeeId);         
        }else{
            $att->whereIn('employee_id', function($q) use ($shiftmentGroup){
                // return $q->select(['id'])->from('employees')->whereIn('shiftment_group_id', $shiftmentGroup);         
                // aneh juga ketika menggunakan whereIn akan ada error vsprintf(): Too few arguments, ganti pakai whereRaw aja
                $shiftmentGroupString = implode(',', $shiftmentGroup);
                return $q->select(['id'])->from('employees')->whereRaw('shiftment_group_id in ('. $shiftmentGroupString.')');
            });
        }
        
        return $att->get()->groupBy('employee_id');
    }

    private function listWorkshift($startDate, $endDate, $shiftmentGroup, $employeeId){
        $att = Workshift::select(['shiftment_id','employee_id', 'work_date', 'start_hour', 'end_hour'])
            ->with(['employee' => function($q){
                return $q->select(['id', 'resign_date']);
            }])->whereBetween('work_date',[$startDate,$endDate])->orderBy('work_date');
        if(!empty($employeeId)){    
            $att->whereIn('employee_id', $employeeId);         
        }else{
            $att->whereIn('employee_id', function($q) use ($shiftmentGroup){
                // return $q->select(['id'])->from('employees')->whereIn('shiftment_group_id', $shiftmentGroup);    
                // aneh juga ketika menggunakan whereIn akan ada error vsprintf(): Too few arguments, ganti pakai whereRaw aja
                $shiftmentGroupString = implode(',', $shiftmentGroup);
                return $q->select(['id'])->from('employees')->whereRaw('shiftment_group_id in ('. $shiftmentGroupString.')');     
            });
        }
        return $att->disableModelCaching()->get()->groupBy('employee_id');
    }

    private function listOvertime($startDate, $endDate, $shiftmentGroup, $employeeId){
        $att = Overtime::select(['overtime_date', 'id', 'breaktime_value', 'employee_id','start_hour', 'end_hour', 'overday','start_hour_real', 'end_hour_real', 'raw_value', 'calculated_value', 'payroll_calculated_value'])
            ->with(['benefit'])
            ->notReject()            
            ->whereBetween('overtime_date',[$startDate,$endDate]);        
        if(!empty($employeeId)){    
            $att->whereIn('employee_id', $employeeId);         
        }else{
            $att->whereIn('employee_id', function($q) use ($shiftmentGroup){
                // return $q->select(['id'])->from('employees')->whereIn('shiftment_group_id', $shiftmentGroup);
                // aneh juga ketika menggunakan whereIn akan ada error vsprintf(): Too few arguments, ganti pakai whereRaw aja
                $shiftmentGroupString = implode(',', $shiftmentGroup);
                return $q->select(['id'])->from('employees')->whereRaw('shiftment_group_id in ('. $shiftmentGroupString.')');
            });
        }
        return $att->disableModelCaching()->get()->groupBy('employee_id');
    }

    private function listLeaves($startDate, $endDate, $shiftmentGroup, $employeeId){
        if(!empty($employeeId)){
            return LeaveDetails::select(['leave_date', 'employee_id', 'reason_id'])->whereBetween('leave_date',[$startDate,$endDate])->employeeApprove($employeeId)->disableModelCaching()->get()->groupBy('employee_id');
        }
        return LeaveDetails::select(['leave_date', 'employee_id', 'reason_id'])->whereBetween('leave_date',[$startDate,$endDate])->shiftmentGroupApprove($shiftmentGroup)->disableModelCaching()->get()->groupBy('employee_id');
    }

    // cari absent berdasarkan jadwal kerja
    private function getFingerTimeDate($schedule, $fingerLog, $overtimes){        
        $overtime = new OvertimeDay($schedule, $fingerLog, $overtimes, ['min' => $this->getMinCheckin(), 'max' => $this->getMaxCheckout()]);
        return $overtime->getResult();
    }


    /**
     * Get the value of maxCheckout
     */ 
    public function getMaxCheckout()
    {
        return $this->maxCheckout;
    }

    /**
     * Set the value of maxCheckout
     *
     * @return  self
     */ 
    public function setMaxCheckout($maxCheckout)
    {
        $this->maxCheckout = $maxCheckout;

        return $this;
    }

    /**
     * Get the value of minCheckin
     */ 
    public function getMinCheckin()
    {
        return $this->minCheckin;
    }

    /**
     * Set the value of minCheckin
     *
     * @return  self
     */ 
    public function setMinCheckin($minCheckin)
    {
        $this->minCheckin = $minCheckin;

        return $this;
    }

    /**
     * Get the value of reason
     */ 
    public function getReason($id = NULL)
    {        
        return is_null($id) ? $this->reason : $this->reason[$id];
    }

    /**
     * Set the value of reason
     *
     * @return  self
     */ 
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get the value of lateinTolerance
     */ 
    public function getLateinTolerance()
    {
        return $this->lateinTolerance;
    }

    /**
     * Set the value of lateinTolerance
     *
     * @return  self
     */ 
    public function setLateinTolerance($lateinTolerance)
    {
        $this->lateinTolerance = $lateinTolerance;

        return $this;
    }
}
