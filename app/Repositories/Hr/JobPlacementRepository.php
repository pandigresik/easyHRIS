<?php

namespace App\Repositories\Hr;

use App\Models\Hr\JobPlacement;
use App\Repositories\BaseRepository;

/**
 * Class JobPlacementRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class JobPlacementRepository extends BaseRepository
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
        'active'
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
        return JobPlacement::class;
    }
}
