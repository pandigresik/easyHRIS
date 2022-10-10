<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Leaf;
use App\Repositories\BaseRepository;

/**
 * Class LeafRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class LeafRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'reason_id',
        'leave_date',
        'amount',
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
        return Leaf::class;
    }
}
