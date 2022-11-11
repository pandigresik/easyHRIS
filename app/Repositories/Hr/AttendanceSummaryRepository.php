<?php

namespace App\Repositories\Hr;

use App\Models\Base\Setting;
use App\Models\Hr\Attendance;
use App\Models\Hr\AttendanceSummary;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

/**
 * Class AttendanceSummaryRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class AttendanceSummaryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'year',
        'month',
        'total_workday',
        'total_in',
        'total_loyality',
        'total_absent',
        'total_overtime'
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
        return AttendanceSummary::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        
        try {
            $rangePeriod = $input['range_period'];
            $period = generatePeriod($rangePeriod);
            $startDate = $period['startDate'];            
            $endDate = $period['endDate'];
            $employeeId = $input['employee_id'] ?? [];
            
            // pastikan attendance sudah tidak ada yang berstatus INVALID
            $invalidAttendance = Attendance::whereBetween('attendance_date', [$startDate, $endDate])->invalid()->count();
            if($invalidAttendance > 0){
                throw(new \Exception('Masih ada '.$invalidAttendance.' data invalid <a href="'.route('hr.attendances.index').'">proses absensi</a>'));
            }
            $summaries = $this->summary($startDate, $endDate, $employeeId);
            $userId = \Auth::id();
            $startDateObj = Carbon::parse($startDate);
            if(!$summaries->isEmpty()){
                foreach($summaries as $summary){
                    $dataInsert = $summary->toArray();
                    $dataInsert['total_in'] = $dataInsert['total_workday'] - $dataInsert['total_absent'];
                    $dataInsert['total_loyality'] = 0;
                    $dataInsert['total_overtime'] = 0;
                    $dataInsert['year'] = $startDateObj->format('Y');
                    $dataInsert['month'] = $startDateObj->format('m');
                    $dataInsert['created_by'] = $userId;
                    AttendanceSummary::upsert($dataInsert,['employee_id', 'year', 'month']);
                }
            }
            $this->model->getConnection()->commit();            
            $this->model->newInstance()->flushCache();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    private function summary($startDate, $endDate, $employeeId = []){
        $toleranceLate = Setting::select(['value'])->where(['name' => 'latein_tolerance', 'type' => 'attendance'])->first();
        $shiftmentOff = config('local.shiftment_off');
        $leaveCode = implode("','",config('local.leave_code'));
        $summary = Attendance::selectRaw("
            employee_id, sum(absent) as total_absent, sum(case when state = 'OFF' then 1 else 0 end) as total_off 
            , sum(case when late_in > $toleranceLate->value then late_in else 0 end) as total_late_in
            , sum(early_out) as total_early_out
            , count(*) as total_workday
            , sum(case when state in ('$leaveCode') then 1 else 0 end) as total_leave
        ")->whereBetween('attendance_date', [$startDate, $endDate])
        ->whereNotIn('shiftment_id', $shiftmentOff);
        if(!empty($employeeId)){
            $summary->whereIn('employee_id', $employeeId);
        }
        return $summary->groupBy('employee_id')->get();
    }
}
