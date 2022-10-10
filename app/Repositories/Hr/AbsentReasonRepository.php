<?php

namespace App\Repositories\Hr;

use App\Models\Hr\AbsentReason;
use App\Repositories\BaseRepository;

/**
 * Class AbsentReasonRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class AbsentReasonRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'code',
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
        return AbsentReason::class;
    }
}
