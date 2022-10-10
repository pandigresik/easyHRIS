<?php

namespace App\Repositories\Base;

use App\Models\Base\City;
use App\Repositories\BaseRepository;

/**
 * Class CityRepository
 * @package App\Repositories\Base
 * @version October 4, 2022, 10:36 am WIB
*/

class CityRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'region_id',
        'code',
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
        return City::class;
    }
}
