<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SalaryBenefitHistory;
use App\Repositories\BaseRepository;

/**
 * Class SalaryBenefitHistoryRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SalaryBenefitHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'component_id',
        'contract_id',
        'new_benefit_value',
        'old_benefit_value',
        'benefit_key',
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
        return SalaryBenefitHistory::class;
    }
}
