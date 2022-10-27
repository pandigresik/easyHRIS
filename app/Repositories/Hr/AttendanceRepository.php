<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Employee;
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

    public function create($input)
    {
        try {
            $period = generatePeriod($input['work_date_period']);
            $startDate = $period['startDate'];
            $endDate = $period['endDate'];
            $shiftmentGroup = $input['shiftment_group_id'] ?? [];
            $employeeId = $input['employee_id'] ?? [];
            $this->processAttendance($startDate, $endDate, $shiftmentGroup, $employeeId);
            // $model = $this->model->newInstance($input);
            // $model->save();
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
            $this->processEmployeeAttendance($log, $workshift, $overtime, $leave);
            
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
            $nextDate = Carbon::parse($date)->addDay()->format('Y-m-d');
            $fingerLogData = $logDate[$date] ?? collect([]);
            $fingerLogData = isset($logDate[$nextDate]) ? $fingerLogData->merge($logDate[$nextDate]) : collect([])  ;
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
            ];
            if(!$fingerLogData->isEmpty()){
                $fingerClassification = $this->getFingerTimeDate($schedule, $fingerLogData);
                $tmp['check_in'] = $fingerClassification['check_in'];
                $tmp['check_out'] = $fingerClassification['check_out'];

                $tmp['early_in'] = $tmp['check_in_schedule'] > $fingerClassification['check_in'] ? diffMinute($fingerClassification['check_in'], $tmp['check_in_schedule']): 0;
                $tmp['early_out'] = $tmp['check_out_schedule'] > $fingerClassification['check_out'] ? diffMinute($fingerClassification['check_out'], $tmp['check_out_schedule']): 0;
                
                $tmp['late_in'] = $fingerClassification['check_in'] > $tmp['check_in_schedule'] ? diffMinute($fingerClassification['check_in'], $tmp['check_in_schedule']): 0;
                $tmp['late_out'] = $fingerClassification['check_out'] > $tmp['check_out_schedule'] ? diffMinute($fingerClassification['check_out'], $tmp['check_out_schedule']): 0;
                $tmp['absent'] = 0;
            }
                                    
            $attendanceResult[] = $tmp;
        }
        \Log::error($attendanceResult);
    }
    // untuk data attendance tambahhkan h+1 untuk endDate, karena bisa jadi overday misal ketika shift 3
    private function listAttendanceLog($startDate, $endDate, $shiftmentGroup, $employeeId){
        $endDate = Carbon::parse($endDate)->addDay()->format('Y-m-d');
        
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
        })->get()->groupBy('employee_id');
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
    private function getFingerTimeDate($schedule, $fingerLog){        
        $result = ['check_in' => null, 'check_out' => null];
        foreach($fingerLog as $time){
            if(is_null($result['check_in'])){
                if($time <= $schedule->getRawOriginal('start_hour')){
                    $result['check_in'] = $time;
            }

            if(is_null($result['check_out'])){
                if($time > $schedule->getRawOriginal('end_hour')){
                    $result['check_out'] = $time;
                }
            }
        }
        return $result;
    }
}
