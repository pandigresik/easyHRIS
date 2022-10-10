<?php

namespace App\Repositories\Hr;

use App\Models\Hr\PayrollDetail;
use App\Repositories\BaseRepository;

/**
 * Class PayrollDetailRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 11:17 am WIB
*/

class PayrollDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'payroll_id',
        'component_id',
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
        return PayrollDetail::class;
    }
}
