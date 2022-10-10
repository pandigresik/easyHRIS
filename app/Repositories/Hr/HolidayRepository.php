<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Holiday;
use App\Repositories\BaseRepository;

/**
 * Class HolidayRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class HolidayRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'holiday_date',
        'name'
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
        return Holiday::class;
    }
}
