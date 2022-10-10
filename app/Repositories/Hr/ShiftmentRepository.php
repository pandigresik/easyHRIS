<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Shiftment;
use App\Repositories\BaseRepository;

/**
 * Class ShiftmentRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class ShiftmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
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
        return Shiftment::class;
    }
}
