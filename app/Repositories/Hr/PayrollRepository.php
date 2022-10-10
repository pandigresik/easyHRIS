<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Payroll;
use App\Repositories\BaseRepository;

/**
 * Class PayrollRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 11:17 am WIB
*/

class PayrollRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'payroll_period_id',
        'take_home_pay',
        'take_home_pay_key'
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
        return Payroll::class;
    }
}
