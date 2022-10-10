<?php

namespace App\Repositories\Hr;

use App\Models\Hr\EducationalInstitute;
use App\Repositories\BaseRepository;

/**
 * Class EducationalInstituteRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class EducationalInstituteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        return EducationalInstitute::class;
    }
}
