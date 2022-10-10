<?php

namespace App\Repositories\Hr;

use App\Models\Hr\EmployeeShiftment;
use App\Repositories\BaseRepository;

/**
 * Class EmployeeShiftmentRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class EmployeeShiftmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_group_id',
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
        return EmployeeShiftment::class;
    }
}
