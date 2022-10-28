<?php

namespace App\Repositories\Hr;

use App\Models\Base\Setting;
use App\Models\Hr\AbsentReason;
use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\LeaveDetails;
use App\Models\Hr\Overtime;
use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
    }

    private function setReasonAttendance(){
        $this->setReason(AbsentReason::pluck('code', 'id')->toArray());
    }

    public function create($input)
    {
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
            return $this->model;
        } catch (\Exception $e) {
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
            $attendanceResult = $this->processEmployeeAttendance($log, $workshift, $overtime, $leave);
            if(!empty($attendanceResult)){
                Attendance::upsert($attendanceResult, ['employee_id', 'attendance_date']);
            }
        }        
    }

    private function processEmployeeAttendance($log, $workshift, $overtime, $leave){
        $workshiftDate = $workshift->keyBy(function($item){ return $item->getRawOriginal('work_date');});
        $logDate = $log->groupBy('finger_date');
        
        $overtimeDate = $overtime->keyBy(function($item){ return $item->getRawOriginal('overtime_date');});
        $leaveDate = $leave->keyBy(function($item){ return $item->getRawOriginal('leave_date');});
        $attendanceResult = [];
        foreach($workshiftDate as $date => $schedule){
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
                'reason_id' => isset($leaveDate[$date]) ? $leaveDate[$date]->first()->reason_id : null,
                'attendance_date' => $schedule->getRawOriginal('work_date'),
                'description' => null,
                'check_in_schedule' => $schedule->getRawOriginal('start_hour'),
                'check_out_schedule' => $schedule->getRawOriginal('end_hour'),                                
                'absent' => 1,
                'early_in' => 0,
                'early_out' => 0,
                'late_in' => 0,
                'late_out' => 0, 
                'check_in' => NULL,
                'check_out' => NULL,
                'state' => $schedule->getRawOriginal('start_hour') == $schedule->getRawOriginal('end_hour') ? 'OK' : 'INVALID',
                'created_by' => \Auth::id()
            ];

            if(!empty($tmp['reason_id'])){
                $tmp['state'] = $this->getReason($tmp['reason_id']); 
            }
            
            if(!$fingerLogData->isEmpty()){
                $fingerClassification = $this->getFingerTimeDate($schedule, $fingerLogData, $overtimeDate[$date] ?? []);
                $tmp['check_in'] = $fingerClassification['check_in'];
                $tmp['check_out'] = $fingerClassification['check_out'];
                
                if(!is_null($tmp['check_in'])){
                    $tmp['early_in'] = $tmp['check_in_schedule'] > $fingerClassification['check_in'] ? diffMinute($fingerClassification['check_in'], $tmp['check_in_schedule']): 0;
                    $tmp['late_in'] = $fingerClassification['check_in'] > $tmp['check_in_schedule'] ? diffMinute($fingerClassification['check_in'], $tmp['check_in_schedule']): 0;
                }
                
                if(!is_null($tmp['check_out'])){
                    $tmp['early_out'] = $tmp['check_out_schedule'] > $fingerClassification['check_out'] ? diffMinute($fingerClassification['check_out'], $tmp['check_out_schedule']): 0;                                
                    $tmp['late_out'] = $fingerClassification['check_out'] > $tmp['check_out_schedule'] ? diffMinute($fingerClassification['check_out'], $tmp['check_out_schedule']): 0;
                }

                if(!is_null($tmp['check_out']) && !is_null($tmp['check_in'])){
                    if($tmp['late_in'] > 0){
                        $tmp['state'] = 'LATEIN';
                    } else if($tmp['early_out'] > 0){
                        $tmp['state'] = 'EARLYOUT';
                    }else{
                        $tmp['state'] = 'OK';
                    }
                }
                $tmp['absent'] = 0;
            }
                                    
            $attendanceResult[] = $tmp;            
        }
        
        return $attendanceResult;
    }
    // untuk data attendance tambahhkan h+1 untuk endDate, karena bisa jadi overday misal ketika shift 3
    private function listAttendanceLog($startDate, $endDate, $shiftmentGroup, $employeeId){
        $endDate = Carbon::parse($endDate)->addDay()->format('Y-m-d');
        $startDate = Carbon::parse($startDate)->subDay()->format('Y-m-d');
        return AttendanceLogfinger::select(['employee_id', 'fingertime'])->whereBetween('fingertime',[$startDate.' 00:00:00',$endDate.' 23:59:59'])->whereIn('employee_id', function($q) use ($shiftmentGroup, $employeeId){
            if(!empty($employeeId)){
                return $q->select(['id'])->from('employees')->whereIn('id', $employeeId);
            }
            return $q->select(['id'])->from('employees')->where(['shiftment_group_id' => $shiftmentGroup]);
        })->orderBy('fingertime')
        ->get()->groupBy('employee_id');
    }

    private function listWorkshift($startDate, $endDate, $shiftmentGroup, $employeeId){
        return Workshift::select(['shiftment_id','employee_id', 'work_date', 'start_hour', 'end_hour'])->whereBetween('work_date',[$startDate,$endDate])->whereIn('employee_id',function($q) use ($shiftmentGroup, $employeeId){
            if(!empty($employeeId)){
                return $q->select(['id'])->from('employees')->whereIn('id', $employeeId);
            }
            return $q->select(['id'])->from('employees')->where(['shiftment_group_id' => $shiftmentGroup]);
        })->orderBy('work_date')->get()->groupBy('employee_id');
    }

    private function listOvertime($startDate, $endDate, $shiftmentGroup, $employeeId){
        return Overtime::select(['overtime_date', 'employee_id','start_hour', 'end_hour', 'overday'])->whereBetween('overtime_date',[$startDate,$endDate])->whereIn('employee_id',function($q) use ($shiftmentGroup, $employeeId){
            if(!empty($employeeId)){
                return $q->select(['id'])->from('employees')->whereIn('id', $employeeId);
            }
            return $q->select(['id'])->from('employees')->where(['shiftment_group_id' => $shiftmentGroup]);
        })->get()->groupBy('employee_id');
    }

    private function listLeaves($startDate, $endDate, $shiftmentGroup, $employeeId){
        if(!empty($employeeId)){
            return LeaveDetails::select(['leave_date', 'employee_id', 'reason_id'])->whereBetween('leave_date',[$startDate,$endDate])->employeeApprove($employeeId)->get()->groupBy('employee_id');
        }
        return LeaveDetails::select(['leave_date', 'employee_id', 'reason_id'])->whereBetween('leave_date',[$startDate,$endDate])->shiftmentGroupApprove($shiftmentGroup)->get()->groupBy('employee_id');
    }

    // cari absent berdasarkan jadwal kerja
    private function getFingerTimeDate($schedule, $fingerLog, $overtime){
        // jika ada overtime maka ubah max end_hour mengikuti data overtime
        $startHour = $schedule->getRawOriginal('start_hour');
        $endHour = $schedule->getRawOriginal('end_hour');
        // jika hari libur dan ada data overtime maka start dan end mengikuti data overtime
        if(!empty($overtime)){
            $startOvertime = $overtime->getRawOriginal('overtime_date').' '.$overtime->getRawOriginal('start_hour');
            $endOvertime = $overtime->getRawOriginal('overday') ? Carbon::parse($overtime->getRawOriginal('overtime_date'))->addDay()->format('Y-m-d').' '.$overtime->getRawOriginal('end_hour') : $overtime->getRawOriginal('overtime_date').' '.$overtime->getRawOriginal('end_hour');
            if($schedule->getRawOriginal('start_hour') == $schedule->getRawOriginal('end_hour')){
                $startHour = $startOvertime;
                $endHour = $endOvertime;
            }else{
                // lembur di depan
                if($startOvertime < $startHour){
                    $startHour = $startOvertime;
                }
                // lembur di belakang
                if($endOvertime > $endHour){
                    $endHour = $endOvertime;
                }
            }            
        }

        $minCheckin = Carbon::parse($startHour)->subMinutes($this->getMinCheckin())->format('Y-m-d H:i:s');
        $maxCheckout = Carbon::parse($endHour)->addMinutes($this->getMaxCheckout())->format('Y-m-d H:i:s');
        
        $result = ['check_in' => null, 'check_out' => null];
        foreach($fingerLog as $time){            
            if(is_null($result['check_in'])){
                if($time->getRawOriginal('fingertime') >= $minCheckin){
                    if($time->getRawOriginal('fingertime') < $maxCheckout){
                        $result['check_in'] = $time->getRawOriginal('fingertime');
                    }                    
                }
            }
            // jika ada finger baru yang valid maka akan direplace datanya            
            if($time->getRawOriginal('fingertime') <= $maxCheckout && $time->getRawOriginal('fingertime') > $minCheckin ){
                $result['check_out'] = $time->getRawOriginal('fingertime');
            }    
        }
        /** jika nilai checkin dan checkout < 30 menit, maka hapus salah satu */        
        return $this->clearDataAttendance($result, $startHour, $endHour);
    }

    private function clearDataAttendance($result, $startHour, $endHour){
        if(!is_null($result['check_in'])){
            if(!is_null($result['check_out'])){
                $diff = Carbon::parse($result['check_in'])->diffInMinutes($result['check_out']);
                if($diff < 30){
                    $diffIn = Carbon::parse($result['check_in'])->diffInMinutes($startHour);
                    $diffOut = Carbon::parse($result['check_in'])->diffInMinutes($endHour);
                    if($diffIn < $diffOut){
                        $result['check_out'] = NULL;
                    }else{
                        $result['check_in'] = NULL;
                    }
                }
            }
        }
        return $result;
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
}
