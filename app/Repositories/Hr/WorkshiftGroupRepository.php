<?php

namespace App\Repositories\Hr;

use App\Models\Hr\Holiday;
use App\Models\Hr\Shiftment;
use App\Models\Hr\ShiftmentGroup;
use App\Models\Hr\WorkshiftGroup;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

/**
 * Class WorkshiftGroupRepository
 * @package App\Repositories\Hr
 * @version October 13, 2022, 2:38 pm WIB
*/

class WorkshiftGroupRepository extends BaseRepository
{
    /**
     * @var array
     */
    private $shiftmentMovement = Carbon::MONDAY;
    private $shiftmentOff = 2; // index shift libur
    private $dayOff = Carbon::SUNDAY;
    protected $fieldSearchable = [
        'shiftment_group_id',
        'shiftment_id',
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
        return WorkshiftGroup::class;
    }
    /** parameter 
     * 'startDate' => $period['startDate'],
     * 'endDate' => $period['endDate'],
     * 'shiftmentGroup' => $shiftmentGroup */
    public function generateWorkshift($data){
        $startDate = $data['startDate'];
        $endDate = $data['endDate'];
        /** cari urutan shift untuk grup tersebut */
        $shiftmentGroup = ShiftmentGroup::with(['shiftmentGroupDetails'])->find($data['shiftmentGroup']);
        $shiftmentGroupDetails = $shiftmentGroup->shiftmentGroupDetails;
        /** cari shift terakhir sebelumya */
        $lastShift = WorkshiftGroup::where(['shiftment_group_id' => $data['shiftmentGroup']])->where('work_date','<=', $startDate->format('Y-m-d'))->orderBy('work_date','desc')->first();        
        $currentShiftment = NULL;
        if($lastShift){
            $currentShiftment = $lastShift->shiftment_id;
        }
        return [            
            'schedule' => $this->generateScheduleDay($startDate, $endDate, $shiftmentGroupDetails, $currentShiftment)
        ];
    }
    /** return index shiftment */
    protected function getNextShiftment($shiftmentGroupDetails, $currentShiftment = NULL){
        $shiftmentGroupDetailByShiftment = $shiftmentGroupDetails->pluck('sequence','shiftment_id');
        $shiftmentGroupDetailBySequence = $shiftmentGroupDetails->sortBy('sequence')->pluck('shiftment_id','sequence');
        
        $firstShiftment = $shiftmentGroupDetailBySequence->keys()->min();
        
        if($currentShiftment){
            $sequence = $shiftmentGroupDetailByShiftment[$currentShiftment];
            $nextIndexSequence = $sequence + 1;
            if($nextIndexSequence > $shiftmentGroupDetailBySequence->keys()->max()) {
                $nextIndexSequence = $firstShiftment;
            }
        }else{
            $nextIndexSequence = $firstShiftment;
        }
                
        $nextShiftment = $shiftmentGroupDetailBySequence[$nextIndexSequence];
        return $nextShiftment;
    }

    private function generateScheduleDay($startDate, $endDate, $shiftmentGroupDetails, $firstShiftment = NULL){
        $result = [];
        $period = CarbonPeriod::create($startDate, $endDate);
        
        $shifment = Shiftment::with(['schedules'])->get()->keyBy('id');
        $currentShiftment = $firstShiftment ?? $this->getNextShiftment($shiftmentGroupDetails, $firstShiftment);
        /** cari hari libur di range tanggal tersebut */
        $holiday = Holiday::whereBetween('holiday_date',[$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])->get()->pluck('holiday_date','holiday_date');
        
        foreach($period as $date){
            if($date->dayOfWeek == $this->shiftmentMovement){
                $currentShiftment = $this->getNextShiftment($shiftmentGroupDetails, $currentShiftment);
            }                        
            $result[$date->format('Y-m-d')] = $shifment[$currentShiftment];
            $currentScheduleShiftment = $shifment[$currentShiftment]->schedules->keyBy('work_day');
            /* jika jam awal = jam akhir maka hari libur */
            if($currentScheduleShiftment[$date->dayOfWeek]->start_hour == $currentScheduleShiftment[$date->dayOfWeek]->end_hour){
                $result[$date->format('Y-m-d')] = $shifment[$this->shiftmentOff];
            }

            if(isset($holiday[$date->format('Y-m-d')])){
                $result[$date->format('Y-m-d')] = $shifment[$this->shiftmentOff];
            }
        }
        return $result;
    }
}