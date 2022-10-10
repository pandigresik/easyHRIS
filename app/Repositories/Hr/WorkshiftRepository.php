<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Workshift;
use App\Repositories\BaseRepository;

/**
 * Class WorkshiftRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:39 am WIB
*/

class WorkshiftRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'description',
        'work_date'
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
        return Workshift::class;
    }
}
