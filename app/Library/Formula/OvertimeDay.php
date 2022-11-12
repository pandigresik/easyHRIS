<?php
namespace App\Library\Formula;

use Carbon\Carbon;

class OvertimeDay{
    private $logFingers;    
    private $overtimes;
    private $workshift;
    private $startHour;
    private $endHour;
    private $constraint = [
        'min' => 0,
        'max' => 0,
    ];
    private $result = [
        'checkin' => null,
        'checkout' => null,
        'overtimes' => []
    ];

    function __construct($workshift, $logFingers, $overtimes, $constraint)
    {
        $this->logFingers = $logFingers;
        $this->overtimes = $overtimes;
        $this->workshift = $workshift;
        $this->constraint = $constraint;
        $this->setStartEndHour();
        $this->setCheckInOut();
        $this->calculateOvertime();
    }

    private function calculateOvertime(){
        $startWorkshift = $this->workshift->getRawOriginal('start_hour');
        $endWorkshift = $this->workshift->getRawOriginal('end_hour');
        $checkInReal = $this->result['checkin'];
        $checkOutReal = $this->result['checkout'];
        foreach($this->overtimes as $ot){
            $startOvertime = $ot->getRawStartHourDate();
            $endOvertime = $ot->getRawEndHourDate();
            
            // lembur awal
            if($startOvertime < $startWorkshift){
                if($endOvertime < $endWorkshift){
                    $ot->start_hour_real = Carbon::parse($checkInReal)->format('H:i:s');
                    $ot->end_hour_real = $ot->getRawOriginal('end_hour');
                    $rawValue = Carbon::parse($startOvertime)->diffInMinutes($endOvertime);
                    $calculateValue = Carbon::parse($checkInReal)->diffInMinutes($endOvertime);
                    $ot->raw_value = $rawValue;
                    $ot->calculated_value = $calculateValue;    
                }
            }
            // lembur tengah
            if($startOvertime > $startWorkshift){
                if($endOvertime < $endWorkshift){
                    $ot->start_hour_real = $ot->getRawOriginal('end_hour');
                    $ot->end_hour_real = $ot->getRawOriginal('end_hour');
                    $rawValue = Carbon::parse($startOvertime)->diffInMinutes($endOvertime);                    
                    $ot->raw_value = $rawValue;
                    $ot->calculated_value = $rawValue;    
                }
            }

            // lembur akhir
            if($endOvertime >= $endWorkshift){
                if($endOvertime < $endWorkshift){
                    $ot->start_hour_real = $ot->getRawOriginal('end_hour');
                    $ot->end_hour_real = $ot->getRawOriginal('end_hour');
                    $rawValue = Carbon::parse($startOvertime)->diffInMinutes($endOvertime);                    
                    $ot->raw_value = $rawValue;
                    $ot->calculated_value = $rawValue;    
                }
            }
            

            $this->result['overtimes'][] = $ot;            
        }
    }

    private function setStartEndHour(){
        $this->startHour = $this->workshift->getRawOriginal('start_hour');
        $this->endHour = $this->workshift->getRawOriginal('end_hour');
        foreach($this->overtimes as $ot){
            $startOvertime = $ot->getRawStartHourDate();
            $endOvertime = $ot->getRawEndHourDate();
            if($startOvertime < $this->startHour){
                $this->startHour = $startOvertime;
            }

            if($endOvertime > $this->endHour){
                $this->endHour = $endOvertime;
            }            
        }

        $this->startHour = Carbon::parse($this->startHour)->subMinutes($this->constraint['min'])->format('Y-m-d H:i:s');
        $this->endHour = Carbon::parse($this->endHour)->addMinutes($this->constraint['max'])->format('Y-m-d H:i:s');
    }

    private function setCheckInOut(){
        foreach($this->logFingers as $time){            
            if(is_null($this->result['checkin'])){
                if($time->getRawOriginal('fingertime') >= $this->startHour){
                    if($time->getRawOriginal('fingertime') < $this->endHour){
                        $this->result['checkin'] = $time->getRawOriginal('fingertime');
                    }
                }
            }
            // jika ada finger baru yang valid maka akan direplace datanya            
            if($time->getRawOriginal('fingertime') <= $this->endHour) {
                if ($time->getRawOriginal('fingertime') > $this->startHour){
                    $this->result['checkout'] = $time->getRawOriginal('fingertime');
                }
            }
        }
    }
    /**
     if(!empty($overtimeCurrentDate)){
                $startOvertime = $overtimeCurrentDate->getRawOriginal('overtime_date').' '.$overtimeCurrentDate->getRawOriginal('start_hour');
                $endOvertime = $overtimeCurrentDate->getRawOriginal('overday') ? Carbon::parse($overtimeCurrentDate->getRawOriginal('overtime_date'))->addDay()->format('Y-m-d').' '.$overtimeCurrentDate->getRawOriginal('end_hour') : $overtimeCurrentDate->getRawOriginal('overtime_date').' '.$overtimeCurrentDate->getRawOriginal('end_hour');
                $realStartOvertime = substr($startOvertime, -8);
                $realEndOvertime = substr($endOvertime, -8);                 
                $overtimeCurrentDate->end_hour_real = $realEndOvertime;
                $overtimeCurrentDate->start_hour_real = $realStartOvertime;
                // lembur diakhir
                if(!empty($tmp['check_out'])){                    
                    if(($endOvertime > $tmp['check_out_schedule']) || isWorkshiftOff($tmp)){
                        $realEndOvertime = substr($tmp['check_out'], -8);
                        $overtimeCurrentDate->end_hour_real = $realEndOvertime;
                    }               
                }
                // lembur awal
                if(!empty($tmp['check_in'])){                   
                    if(($startOvertime < $tmp['check_in_schedule']) || isWorkshiftOff($tmp) ){
                        $realStartOvertime = substr($tmp['check_in'], -8);
                        $overtimeCurrentDate->start_hour_real = $realStartOvertime;
                    }                                     
                }
                
                $startRealOvertime = $overtimeCurrentDate->getRawOriginal('overtime_date').' '.$realStartOvertime;
                $endRealOvertime = $overtimeCurrentDate->getRawOriginal('overday') ? Carbon::parse($overtimeCurrentDate->getRawOriginal('overtime_date'))->addDay()->format('Y-m-d').' '.$realEndOvertime : $overtimeCurrentDate->getRawOriginal('overtime_date').' '.$realEndOvertime;
                $maxHourOvertime = Carbon::parse($startOvertime)->diffInMinutes($endOvertime);
                $rawValue = Carbon::parse($startRealOvertime)->diffInMinutes($endRealOvertime);
                $calculateValue = $rawValue > $maxHourOvertime ? $maxHourOvertime :  $rawValue;
                $amountOvertime = $overtimeCurrentDate->benefit->getRawOriginal('benefit_value') ?? 0;
                $overtimeCurrentDate->raw_value = $rawValue;
                $overtimeCurrentDate->calculated_value = $calculateValue;              
                $overtimeCurrentDate->amount = (new SalaryComponentOvertime(minuteToHour($calculateValue) , $amountOvertime))->calculate();
                $overtimeResult[] = $overtimeCurrentDate;
                
            }
     */
}