<?php

namespace App\Repositories\Hr;

use App\Models\Hr\CareerHistory;
use App\Repositories\BaseRepository;

/**
 * Class CareerHistoryRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class CareerHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'company_id',
        'department_id',
        'joblevel_id',
        'jobtitle_id',
        'supervisor_id',
        'contract_id',
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
        return CareerHistory::class;
    }
}
