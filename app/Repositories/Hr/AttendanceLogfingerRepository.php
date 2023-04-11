<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Models\Hr\AttendanceLogfinger;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

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

    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        $jobs = [];
        try {            
            $employees = $input['employee_id'];
            foreach($employees as $employee){
                $input['employee_id'] = $employee;
                $model = parent::create($input);
                $jobs[] = $model;                
            }
            
            $this->model->getConnection()->commit();  
            // kita keluarkan dari blok transaction, karena job akan membaca table attendance_log
            // jadi job diinsert setelah commit saja
            if($jobs){
                $this->generateJob($jobs);
            }
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }

    }

    /**
     * Update model record for given id.
     *
     * @param array $input
     * @param int   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        try{            
            $model = parent::update($input, $id);            
            $this->generateJob([$model]);
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    private function generateJob($jobs){
        foreach($jobs as $item){
            // execute job attendance process after 30 seconds                        
            if($item->fingerDate < Carbon::now()->format('Y-m-d')){
                AttendanceProcess::dispatch($item->employee_id, $item->fingerDate, $item->fingerDate)->delay(now()->addSeconds(5));
            }
        }                
    }
}
