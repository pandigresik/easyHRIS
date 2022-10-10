<?php

namespace App\Repositories\Hr;

use App\Models\Hr\ShiftmentGroup;
use App\Repositories\BaseRepository;

/**
 * Class ShiftmentGroupRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class ShiftmentGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'company_id',
        'shiftment_id',
        'name'
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
        return ShiftmentGroup::class;
    }
}
