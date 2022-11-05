<?php

namespace App\Repositories\Hr;

use App\Models\Hr\RitaseDriver;
use App\Repositories\BaseRepository;

/**
 * Class RitaseDriverRepository
 * @package App\Repositories\Hr
 * @version November 5, 2022, 12:32 pm WIB
*/

class RitaseDriverRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'work_date',
        'km',
        'double_rit'
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
        return RitaseDriver::class;
    }
}
