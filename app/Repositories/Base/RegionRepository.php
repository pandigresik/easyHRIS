<?php

namespace App\Repositories\Base;

use App\Models\Base\Region;
use App\Repositories\BaseRepository;

/**
 * Class RegionRepository
 * @package App\Repositories\Base
 * @version October 4, 2022, 10:36 am WIB
*/

class RegionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return Region::class;
    }
}
