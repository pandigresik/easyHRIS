<?php

namespace App\Repositories\Hr;

use App\Models\Hr\ShiftmentSchedule;
use App\Repositories\BaseRepository;

/**
 * Class ShiftmentScheduleRepository
 * @package App\Repositories\Hr
 * @version October 13, 2022, 9:59 am WIB
*/

class ShiftmentScheduleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'shiftment_id',
        'work_day',
        'start_hour',
        'end_hour'
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
        return ShiftmentSchedule::class;
    }
}
