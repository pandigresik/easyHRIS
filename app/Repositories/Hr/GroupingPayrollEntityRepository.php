<?php

namespace App\Repositories\Hr;

use App\Models\Hr\GroupingPayrollEntity;
use App\Repositories\BaseRepository;

/**
 * Class GroupingPayrollEntityRepository
 * @package App\Repositories\Hr
 * @version November 18, 2022, 9:48 am WIB
*/

class GroupingPayrollEntityRepository extends BaseRepository
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
        return GroupingPayrollEntity::class;
    }
}
