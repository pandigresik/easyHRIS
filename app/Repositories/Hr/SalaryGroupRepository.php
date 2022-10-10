<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SalaryGroup;
use App\Repositories\BaseRepository;

/**
 * Class SalaryGroupRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SalaryGroupRepository extends BaseRepository
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
        return SalaryGroup::class;
    }
}
