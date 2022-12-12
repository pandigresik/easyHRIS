<?php

namespace App\Repositories\Hr;

use App\Library\SalaryComponent\Overtime as SalaryComponentOvertime;
use App\Models\Hr\Employee;
use App\Models\Hr\Overtime;
use App\Models\Hr\SalaryBenefit;
use App\Repositories\BaseRepository;
use Exception;

/**
 * Class OvertimeRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 8:16 am WIB
*/

class OvertimeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'approved_by_id',
        'overtime_date',
        'start_hour',
        'end_hour',
        'start_hour_real',
        'end_hour_real',
        'raw_value',
        'calculated_value',
        'holiday',
        'overday',
        'description'
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
        return Overtime::class;
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

        try {
            $employees = $input['employee_id'];
            unset($input['employee_id']);
            if(is_null($input['breaktime_value'])){
                $input['breaktime_value'] = 0;
            }
            foreach($employees as $employee){
                $input['employee_id'] = $employee;
                // pastikan tidak ada yang kembar data overtimenya
                $this->isOvertimeExist($input);                
                $model = parent::create($input);
            }
                        
            $this->model->getConnection()->commit();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $this->model->getConnection()->rollBack();

            return $e;
        }

        return $model;
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $model->fill($input);
            $salaryBenefit = SalaryBenefit::where(['employee_id' => $model->employee_id])->where('component_id', function($q){
                return $q->select(['id'])->from('salary_components')->where(['code' => 'OT']);
            })->first();
            $amountOvertime = $salaryBenefit->getRawOriginal('benefit_value');
            $model->amount = (new  SalaryComponentOvertime(minuteToHour($model->calculated_value) , $amountOvertime))->calculate();
            $model->save();
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }

    private function isOvertimeExist($overtime){
        $first = Overtime::where(['employee_id' => $overtime['employee_id'], 'start_hour' => $overtime['start_hour'], 'overtime_date' => $overtime['overtime_date']])->first();
        if($first){
            $employee = Employee::find($overtime['employee_id']);
            throw new Exception("Data overtime karyawan ".$employee->code_name. " tanggal ".$first->overtime_date." jam ".$first->start_hour." sudah ada");
        }
    }
}
