<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Employee;
use App\Models\Hr\RitaseDriver;
use App\Repositories\BaseRepository;
use Exception;

/**
 * Class RitaseDriverRepository
 * @package App\Repositories\Hr
 * @version November 5, 2022, 12:32 pm WIB
*/

class RitaseDriverRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'work_date',
        'km',
        'double_rit'
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
        return RitaseDriver::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {            
            $this->isOvertimeExist($input);
            $model = parent::create($input);         
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try {            
            $this->isOvertimeExist($input);
            $model = parent::update($input, $id);
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function isOvertimeExist($ritase){
        $first = RitaseDriver::where(['employee_id' => $ritase['employee_id'], 'work_date' => $ritase['work_date']])->first();
        if($first){
            $employee = Employee::find($ritase['employee_id']);
            throw new  Exception("Data ritase karyawan ".$employee->code_name. " tanggal ".$first->work_date."  sudah ada");
        }
    }
}
