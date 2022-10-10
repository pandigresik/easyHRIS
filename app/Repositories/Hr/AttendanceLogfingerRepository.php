<?php

namespace App\Repositories\Hr;

use App\Models\Hr\AttendanceLogfinger;
use App\Repositories\BaseRepository;

/**
 * Class AttendanceLogfingerRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:38 am WIB
*/

class AttendanceLogfingerRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'type_absen',
        'fingertime',
        'fingerprint_device_id'
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
        return AttendanceLogfinger::class;
    }
}
