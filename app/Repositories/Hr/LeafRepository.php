<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Leaf;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

/**
 * Class LeafRepository
 * @package App\Repositories\Hr
 * @version October 22, 2022, 9:27 am WIB
*/

class LeafRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'reason_id',
        'leave_start',
        'leave_end',
        'amount',
        'status',
        'step_approval',
        'amount_approval',
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
        return Leaf::class;
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {               
            $leaveEnd = Carbon::parse($input['leave_end']);
            $leaveStart = Carbon::parse($input['leave_start']);
            $input['amount'] = $leaveEnd->diffInDays($leaveStart) + 1;
            $input['status'] = Leaf::INITIAL_STATE;
            $employees = $input['employee_id'];
            unset($input['employee_id']);
            $details = [];
            foreach(CarbonPeriod::create($leaveStart, $leaveEnd) as $date ){
                $details[] = ['leave_date' => $date->format('Y-m-d')];
            }
            //foreach($employees as $employee){
                $input['employee_id'] = $employees[0];
                $model = parent::create($input);
                \Log::error($model);                
                $model->details()->sync($details);
            //}
            
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {            
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }

    public function update($input, $id)
    {
        $this->model->getConnection()->beginTransaction();
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $leaveEnd = Carbon::parse($input['leave_end']);
            $leaveStart = Carbon::parse($input['leave_start']);
            $input['amount'] = $leaveEnd->diffInDays($leaveStart) + 1;
            $model->fill($input);
            $model->save();
            $details = [];
            foreach(CarbonPeriod::create($leaveStart, $leaveEnd) as $date ){
                $details[] = ['leave_date' => $date->format('Y-m-d')];
            }
            $model->details()->sync($details);
            $this->model->getConnection()->commit();
            return $model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }        
    }
}
