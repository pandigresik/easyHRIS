<?php

namespace App\Repositories\Hr;

use App\Models\Hr\AttendanceSummary;
use App\Repositories\BaseRepository;

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
}
