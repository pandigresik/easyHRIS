<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Repositories\BaseRepository;

/**
 * Class AttendanceRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 8:16 am WIB
*/

class AttendanceReportRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',        
        'reason_id',
        'attendance_date'        
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

    public function list($startDate, $endDate, $grouping){
        $datas = Attendance::employeeDescendants()->disableModelCaching()->whereBetween('attendance_date', [$startDate, $endDate])->groupBy('state')->newQuery(); 
        switch($grouping){
            case 'employee':                
                $datas->selectRaw('count(*) as total, state, employee_id')->with(['employee'])->groupBy('employee_id');
                break;
            case 'date':
                $datas->selectRaw('count(*) as total, state, attendance_date')->groupBy('attendance_date');
                break;
        }
        return $datas->get();
    }
}
