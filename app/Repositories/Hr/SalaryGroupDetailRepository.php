<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SalaryGroupDetail;
use App\Repositories\BaseRepository;

/**
 * Class SalaryGroupDetailRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SalaryGroupDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'component_id',
        'salary_group_id',
        'component_value'
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
        return SalaryGroupDetail::class;
    }
}
