<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Workshift;
use App\Models\Hr\WorkshiftGroup;
use App\Repositories\BaseRepository;

/**
 * Class WorkshiftRepository
 * @package App\Repositories\Hr
 * @version October 4, 2022, 10:39 am WIB
*/

class WorkshiftRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'employee_id',
        'shiftment_id',
        'description',
        'work_date'
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
        return Workshift::class;
    }

    public function generateSchedule($input)
    {
        $this->model->getConnection()->beginTransaction();
        try {
            $this->deletePreviousData($input);
            $shiftmentGroups = $input['shiftment_group_id'];

            foreach($shiftmentGroups as $shiftmentGroup){
                $inputInsert = $input;
                $inputInsert['shiftment_group_id'] = $shiftmentGroup;
                $result = $this->massInsert($inputInsert);
            }
            
            $this->model->newInstance()->flushCache();
            $this->model->getConnection()->commit();
            return $result;
        } catch (\Exception $e) {
            $this->model->getConnection()->rollBack();
            return $e;
        }
    }    

    private function deletePreviousData($input){
        $employeeId = $input['employee_id'] ?? '';
        $shiftmentGroup = $input['shiftment_group_id'];
        $workDate = $input['work_date_period'];
        $period = generatePeriod($workDate);
        $startDate = $period['startDate'];
        $endDate = $period['endDate'];
        if($employeeId){
            $this->model->whereIn('employee_id', $employeeId)->whereBetween('work_date',[$startDate, $endDate])->forceDelete();
        }else{
            $this->model->whereIn('employee_id', function($q) use($shiftmentGroup){
                $q->select('id')->from('employees')->whereIn('shiftment_group_id', $shiftmentGroup);
            })->whereBetween('work_date',[$startDate, $endDate])->forceDelete();
        }
    }

    private function massInsert($input){
        $employeeId = $input['employee_id'] ?? '';
        $shiftmentGroup = $input['shiftment_group_id'];
        $workDate = $input['work_date_period'];
        $period = generatePeriod($workDate);
        $startDate = $period['startDate'];
        $endDate = $period['endDate'];
        $filterEmployee = '';
        if($employeeId){
            $filterEmployee = ' and e.id in ('.implode(',',$employeeId).')';
        }
        
        $sqlMassInsert = <<<SQL
        insert into workshifts (employee_id , shiftment_id , work_date , start_hour , end_hour , created_by , created_at , updated_at)
        select e.id as employee_id, wg.shiftment_id , wg.work_date , wg.start_hour , wg.end_hour, 1, now(), now() from workshift_groups wg
        join employees e on e.shiftment_group_id = wg.shiftment_group_id and ( e.resign_date is null or e.resign_date >= '{$startDate}') and e.join_date <= '{$startDate}' {$filterEmployee}
        where wg.shiftment_group_id = {$shiftmentGroup} and wg.work_date between '{$startDate}' and '{$endDate}'
SQL;
        return $this->model->fromQuery($sqlMassInsert);
    }

    /** parameter 
     * 'startDate' => $period['startDate'],
     * 'endDate' => $period['endDate'],
     * 'shiftmentGroup' => $shiftmentGroup */
    public function generateWorkshift($data){
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        $shiftmentGroup = $data['shiftmentGroup'];
        return [            
            'schedule' => $this->getScheduleGroup($startDate, $endDate, $shiftmentGroup)
        ];
    }

    private function getScheduleGroup($startDate, $endDate, $shiftmentGroup){
        $result = [];
        $workshiftGroup = WorkshiftGroup::with(['shiftment'])->whereBetween('work_date',[$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->where(['shiftment_group_id' => $shiftmentGroup])->get();
        if(!$workshiftGroup->isEmpty()){
            $result = $workshiftGroup->mapWithKeys(function($item){
                $item->shiftment->start_hour = substr($item->getRawOriginal('start_hour'), -8);
                $item->shiftment->end_hour = substr($item->getRawOriginal('end_hour'), -8);
                return [$item->getRawOriginal('work_date') => $item->shiftment->toArray()];
            });   
        }        
        
        return $result;
    }
}
