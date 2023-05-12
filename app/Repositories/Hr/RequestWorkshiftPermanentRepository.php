<?php

namespace App\Repositories\Hr;

use App\Jobs\AttendanceProcess;
use App\Models\Base\Setting;
use App\Models\Hr\Employee;
use App\Models\Hr\RequestWorkshift;
use App\Models\Hr\WorkshiftGroup;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;

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
        $workshiftGroup = WorkshiftGroup::with(['shiftment'])->whereBetween('work_date', [$startDate, $endDate])
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
            
            return;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }    

    private function generateJob($item, $delay = 2){
        // execute job attendance process after 30 seconds                
        if($item->getRawOriginal('status') == $item->getFinalState()){
            if($item->getRawOriginal('work_date') < Carbon::now()->format('Y-m-d')){
                AttendanceProcess::dispatch($item->employee_id, $item->getRawOriginal('work_date'), $item->getRawOriginal('work_date'))->delay(now()->addSeconds($delay));
            }
        }        
    }
}
