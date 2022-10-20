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
        $workshiftGroup = WorkshiftGroup::with(['shiftment'])->whereBetween('work_date',[$startDate, $endDate])->where(['shiftment_group_id' => $shiftmentGroup])->get();
        if(!$workshiftGroup->isEmpty()){
            $result = $workshiftGroup->mapWithKeys(function($item){
                $item->shiftment->start_hour = $item->start_hour;
                $item->shiftment->end_hour = $item->end_hour;
                return [$item->work_date->format('Y-m-d') => $item->shiftment->toArray()];
            });   
        }
        
        return $result;
    }
}
