<?php

namespace App\Repositories\Hr;

use App\Models\Hr\FingerprintDevice;
use App\Repositories\BaseRepository;

/**
 * Class FingerprintDeviceRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class FingerprintDeviceRepository extends BaseRepository
{
    protected $lookupColumnSelect = ['id' => 'id', 'text' => 'display_name'];
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'serial_number',
        'ip',
        'display_name'
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
        return FingerprintDevice::class;
    }
}
