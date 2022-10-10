<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\TaxGroupHistory;
use App\Repositories\BaseRepository;

/**
 * Class TaxGroupHistoryRepository
 * @package App\Repositories\Accounting
 * @version October 4, 2022, 10:33 am WIB
*/

class TaxGroupHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'old_tax_group',
        'new_tax_group',
        'old_risk_ratio',
        'new_risk_ratio'
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
        return TaxGroupHistory::class;
    }
}
