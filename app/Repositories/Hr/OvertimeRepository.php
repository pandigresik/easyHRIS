<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Overtime;
use App\Repositories\BaseRepository;

/**
 * Class OvertimeRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class OvertimeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'approved_by_id',
        'overtime_date',
        'start_hour',
        'end_hour',
        'raw_value',
        'calculated_value',
        'holiday',
        'overday',
        'description'
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
        return Overtime::class;
    }
}
