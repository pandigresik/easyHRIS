<?php

namespace App\Repositories\Hr;

use App\Models\Hr\SkillGroup;
use App\Repositories\BaseRepository;

/**
 * Class SkillGroupRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class SkillGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'parent_id',
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
        return SkillGroup::class;
    }
}
