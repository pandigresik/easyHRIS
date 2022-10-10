<?php

namespace App\Repositories\Hr;

use App\Models\Hr\JobMutation;
use App\Repositories\BaseRepository;

/**
 * Class JobMutationRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class JobMutationRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'old_company_id',
        'old_department_id',
        'old_joblevel_id',
        'old_jobtitle_id',
        'old_supervisor_id',
        'new_company_id',
        'new_department_id',
        'new_joblevel_id',
        'new_jobtitle_id',
        'new_supervisor_id',
        'contract_id',
        'type'
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
        return JobMutation::class;
    }
}
