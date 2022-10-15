<?php

namespace App\Repositories\Hr;

use App\Models\Hr\ShiftmentGroupDetail;
use App\Repositories\BaseRepository;

/**
 * Class ShiftmentGroupDetailRepository
 * @package App\Repositories\Hr
 * @version October 13, 2022, 9:59 am WIB
*/

class ShiftmentGroupDetailRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'shiftment_group_id',
        'shiftment_id',
        'sequence'
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
        return ShiftmentGroupDetail::class;
    }
}
