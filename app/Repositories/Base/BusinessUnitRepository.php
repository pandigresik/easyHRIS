<?php

namespace App\Repositories\Base;

use App\Models\Base\BusinessUnit;
use App\Repositories\BaseRepository;

/**
 * Class BusinessUnitRepository
 * @package App\Repositories\Base
 * @version November 10, 2022, 9:53 am WIB
*/

class BusinessUnitRepository extends BaseRepository
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
        return BusinessUnit::class;
    }
}
