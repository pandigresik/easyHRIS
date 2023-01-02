<?php

namespace App\Repositories\Base;

use App\Models\Base\Approval;
use App\Repositories\BaseRepository;

/**
 * Class ApprovalRepository
 * @package App\Repositories\Base
 * @version December 31, 2022, 8:55 am WIB
*/

class ApprovalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'model',
        'reference',
        'status',
        'comment',
        'sequence',
        'user_id'
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
        return Approval::class;
    }
}
