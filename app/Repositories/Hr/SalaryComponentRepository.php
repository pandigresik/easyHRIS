<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SalaryComponent;
use App\Repositories\BaseRepository;

/**
 * Class SalaryComponentRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SalaryComponentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'state',
        'fixed'
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
        return SalaryComponent::class;
    }
}
