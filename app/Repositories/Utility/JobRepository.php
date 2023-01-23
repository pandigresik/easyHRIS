<?php

namespace App\Repositories\Utility;

use App\Models\Utility\Job;
use App\Repositories\BaseRepository;

/**
 * Class JobRepository
 * @package App\Repositories\Utility
 * @version January 23, 2023, 8:32 am WIB
*/

class JobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'queue',
        'payload',
        'attempts',
        'reserved_at',
        'available_at'
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
        return Job::class;
    }
}
