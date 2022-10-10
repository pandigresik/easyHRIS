<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Contract;
use App\Repositories\BaseRepository;

/**
 * Class ContractRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class ContractRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'letter_number',
        'subject',
        'description',
        'start_date',
        'end_date',
        'signed_date',
        'tags',
        'used'
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
        return Contract::class;
    }
}
