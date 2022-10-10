<?php

namespace App\Repositories\Hr;

use App\Models\Hr\EducationTitle;
use App\Repositories\BaseRepository;

/**
 * Class EducationTitleRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class EducationTitleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'short_name',
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
        return EducationTitle::class;
    }
}
