<?php

namespace App\Repositories\Utility;

use App\Models\Utility\FailedJob;
use App\Repositories\BaseRepository;

/**
 * Class FailedJobRepository
 * @package App\Repositories\Utility
 * @version January 23, 2023, 8:32 am WIB
*/

class FailedJobRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
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
        return FailedJob::class;
    }
}
