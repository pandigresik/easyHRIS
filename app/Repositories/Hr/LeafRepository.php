<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Leaf;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

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
        try {               
            $leaveEnd = Carbon::parse($input['leave_end']);
            $leaveStart = Carbon::parse($input['leave_start']);
            $input['amount'] = $leaveEnd->diffInDays($leaveStart) + 1;
            $model = parent::create($input);
            return $model;
        } catch (\Exception $e) {
            return $e;
        }        
    }

    public function update($input, $id)
    {
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $leaveEnd = Carbon::parse($input['leave_end']);
            $leaveStart = Carbon::parse($input['leave_start']);
            $input['amount'] = $leaveEnd->diffInDays($leaveStart) + 1;
            $model->fill($input);
            $model->save();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
