<?php

namespace App\Repositories\Hr;

use App\Models\Hr\PayrollPeriodGroup;
use App\Repositories\BaseRepository;

/**
 * Class PayrollPeriodGroupRepository
 * @package App\Repositories\Hr
 * @version November 5, 2022, 9:15 am WIB
*/

class PayrollPeriodGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'type_period',
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
        return PayrollPeriodGroup::class;
    }
}
