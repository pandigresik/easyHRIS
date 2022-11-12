<?php

namespace App\Repositories\Hr;

use App\Library\SalaryComponent\Overtime as SalaryComponentOvertime;
use App\Models\Hr\Overtime;
use App\Models\Hr\SalaryBenefit;
use App\Repositories\BaseRepository;

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
            
            foreach($employees as $employee){                
                $input['employee_id'] = $employee;
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
}
