<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Attendance;
use App\Repositories\BaseRepository;

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
}
