<?php

namespace App\Repositories\Accounting;

use App\Models\Accounting\Tax;
use App\Repositories\BaseRepository;

/**
 * Class TaxRepository
 * @package App\Repositories\Accounting
 * @version October 4, 2022, 10:33 am WIB
*/

class TaxRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'period_id',
        'employee_id',
        'tax_group',
        'untaxable',
        'taxable',
        'tax_value',
        'tax_key'
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
        return Tax::class;
    }
}
