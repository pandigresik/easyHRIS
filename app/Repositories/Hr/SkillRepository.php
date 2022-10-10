<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Skill;
use App\Repositories\BaseRepository;

/**
 * Class SkillRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:39 am WIB
*/

class SkillRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'skill_group_id',
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
        return Skill::class;
    }
}
