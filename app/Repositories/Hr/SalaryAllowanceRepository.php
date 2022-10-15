<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SalaryAllowance;
use App\Repositories\BaseRepository;

/**
 * Class SalaryAllowanceRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SalaryAllowanceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'component_id',
        'year',
        'month',
        'benefit_value',
        'benefit_key'
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
        return SalaryAllowance::class;
    }
}