<?php

namespace App\Repositories\Hr;

use App\Models\Hr\JobTitle;
use App\Repositories\BaseRepository;

/**
 * Class JobTitleRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class JobTitleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'job_level_id',
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
        return JobTitle::class;
    }
}
