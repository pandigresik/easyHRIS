<?php

namespace App\Repositories\Hr;

use App\Models\Hr\PayrollPeriod;
use App\Repositories\BaseRepository;

/**
 * Class PayrollPeriodRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 11:17 am WIB
*/

class PayrollPeriodRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'company_id',
        'year',
        'month',
        'closed'
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
        return PayrollPeriod::class;
    }
}
