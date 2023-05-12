<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Models\Hr\Employee;
use App\Models\Hr\RequestWorkshift;
use App\Models\Hr\WorkshiftGroup;
use App\Repositories\BaseRepository;
use Carbon\Carbon;

/**
 * Class RequestWorkshiftRepository
 * @package App\Repositories\Hr
 * @version October 31, 2022, 10:11 am WIB
*/

class RequestWorkshiftPermanentRepository extends BaseRepository
{    
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'shiftment_id_origin',
        'work_date',
        'status',
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
        return RequestWorkshift::class;
    }
    // return array list new schedule in 8 day 
    public function list($filterData){
        $startDate = $filterData['startDate'];
        $employeeFilter = $filterData['employeeFilter'];        
        $shiftmentGroupNew = $filterData['shiftmentGroupNew'];
        $endDate = $filterData['endDate'];
        $workshiftGroup = WorkshiftGroup::with(['shiftment'])->whereBetween('work_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->where(['shiftment_group_id' => $shiftmentGroupNew])
                ->get()->keyBy(function($q){ return $q->getRawOriginal('work_date');});
        return [
            'workshifts' =>  $workshiftGroup->toArray(),
            'employees' => Employee::select(['id','full_name', 'code'])->whereIn('id', $employeeFilter)->get()
        ];
    }

    public function create($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {            
            $shiftmentGroupNew = $input['shiftment_group_id_destination'];            
            $startDate = $input['start_from'];            
            $endDate = WorkshiftGroup::where(['shiftment_group_id' => $shiftmentGroupNew])->max('work_date');
            
            $employeeFilter =  $input['employee_id'];
            Employee::whereIn('id', $employeeFilter)->update(['shiftment_group_id' => $shiftmentGroupNew]);
            $workshift = new WorkshiftRepository();
            $inputWorkshift = $input;
            $inputWorkshift['shiftment_group_id'] = [$shiftmentGroupNew];
            $inputWorkshift['work_date_period'] = implode([$startDate,'__',$endDate]);
            $workshift->generateSchedule($inputWorkshift);            
            $this->model->getConnection()->commit();
            return $this->model;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            \Log::error($e->getMessage());
            return $e;
        }
    }    
}
