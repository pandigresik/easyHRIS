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
        $overtimeType = [
            'start' => 0,
            'middle' => 0,
            'end' => 0
        ];     
        
        if(is_null($checkInReal) || is_null($checkOutReal)){
            foreach($this->overtimes as $ot){
                $this->result['overtimes'][] = $ot; 
            }
            return;
        }
        
        $checkInRealObj = Carbon::parse($checkInReal);
        $checkOutRealObj = Carbon::parse($checkOutReal);
        foreach($this->overtimes as $ot){            
            $startOvertime = $ot->getRawStartHourDate();
            $endOvertime = $ot->getRawEndHourDate();        
            $breakTime = $ot->getRawOriginal('breaktime_value');            
            $ot->start_hour_real = null;
            $ot->end_hour_real = null;
            $ot->raw_value = null;
            $ot->calculated_value = null;
            $finalCalculateValue = 0;            
            // lembur awal, ada kemungkinan karyawan datang terlambat            
            if($checkInRealObj->lessThanOrEqualTo($endOvertime)){
                if($startOvertime < $startWorkshift){ 
                    if($endOvertime < $endWorkshift){
                        $ot->start_hour_real = Carbon::parse($checkInReal)->format('H:i:s');
                        $ot->end_hour_real = $ot->getRawOriginal('end_hour');
                        $pembandingAwal = $checkInReal > $startOvertime ? $checkInReal : $startOvertime;
                        $calculateValue = Carbon::parse($pembandingAwal)->diffInMinutes($endOvertime);
                        $rawValue = $checkInRealObj->diffInMinutes($endOvertime);                        
                        $ot->raw_value = $rawValue;
                        $finalCalculateValue = $calculateValue - $breakTime;
                        // pastikan lembur hanya dihitung satu kali untuk jenis yang sama
                        $overtimeType['start']++;
                        // \Log::error('id '.$ot->id.' data '.$ot->start_hour.' - '.$ot->end_hour.' type start');
                    }

                    if($overtimeType['start'] > 1){
                        $finalCalculateValue = 0;
                    }

                    
                }
                
                // lembur tengah
                if($startOvertime > $startWorkshift){ 
                    if($endOvertime < $endWorkshift){
                        $ot->start_hour_real = $ot->getRawOriginal('start_hour');
                        if($checkOutRealObj->greaterThanOrEqualTo($endOvertime)){
                            $ot->end_hour_real = $ot->getRawOriginal('end_hour');
                            $rawValue = Carbon::parse($startOvertime)->diffInMinutes($endOvertime);
                        }else{
                            $ot->end_hour_real = $checkOutRealObj->format('H:i:s');
                            $rawValue = Carbon::parse($startOvertime)->diffInMinutes($checkOutRealObj);
                        }              
                        $ot->raw_value = $rawValue;
                        $finalCalculateValue = $rawValue - $breakTime;
                        // maksimum tanpa istirahat dianggap 60 menit
                        $finalCalculateValue = $finalCalculateValue > 60 ? 60 : $finalCalculateValue;

                        // pastikan lembur hanya dihitung satu kali untuk jenis yang sama
                        $overtimeType['middle']++;
                        // \Log::error('id '.$ot->id.' data '.$ot->start_hour.' - '.$ot->end_hour.' type middle');
                    }

                    if($overtimeType['middle'] > 1){
                        $finalCalculateValue = 0;
                    }
                    
                }
            }
            
            if($checkOutRealObj->greaterThanOrEqualTo($startOvertime)){
                // lembur akhir dimulai minimal jam pulang jadwal asli
                if($startOvertime >= $endWorkshift){
                    $ot->start_hour_real = $ot->getRawOriginal('start_hour');
                    $ot->end_hour_real = $checkOutRealObj->format('H:i:s');
                    // case hari libur
                    if($this->workshift->isOffShift()){
                        $pembandingAwal = $checkInReal > $startOvertime ? $checkInReal : $startOvertime;
                        $ot->start_hour_real = getTimeString($pembandingAwal);
                        $startOvertime = $pembandingAwal;
                    }

                    $rawValue = Carbon::parse($startOvertime)->diffInMinutes($checkOutRealObj);
                    $calculateValue = $rawValue;
                    if($checkOutRealObj->greaterThanOrEqualTo($endOvertime)){
                        $calculateValue = Carbon::parse($startOvertime)->diffInMinutes($endOvertime);
                    }
                    
                    $ot->raw_value = $rawValue;
                    $finalCalculateValue = $calculateValue - $breakTime;

                    // pastikan lembur hanya dihitung satu kali untuk jenis yang sama
                    $overtimeType['end']++;
                    // \Log::error('id '.$ot->id.' data '.$ot->start_hour.' - '.$ot->end_hour.' type end');
                }

                if($overtimeType['end'] > 1){
                    $finalCalculateValue = 0;
                }
                
            }
            
            $raw_calculated_value = $finalCalculateValue > 0 ? $finalCalculateValue : 0;
            $ot->calculated_value = $finalCalculateValue > 0 ? $finalCalculateValue : 0;
            $ot->payroll_calculated_value = payrollCalculatedOvertimeValue($raw_calculated_value);
            $this->result['overtimes'][] = $ot;            
        }
    }

    private function setStartEndHour(){
        $this->startHour = $this->workshift->getRawOriginal('start_hour');
        $this->endHour = $this->workshift->getRawOriginal('end_hour');  
        
        foreach($this->overtimes as $ot){
            $ot->setValidOvertimeDate($this->workshift);
            $startOvertime = $ot->getRawStartHourDate();
            $endOvertime = $ot->getRawEndHourDate();
            
            // case lembur hari libur
            if($this->workshift->isOffShift()){
                $this->startHour = $startOvertime;
                $this->endHour = $endOvertime;
            }

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
        
        $this->clearDataAttendance();
    }

    private function clearDataAttendance(){        
        if(!is_null($this->result['checkin'])){
            if(!is_null($this->result['checkout'])){
                $diff = Carbon::parse($this->result['checkin'])->diffInMinutes($this->result['checkout']);
                if($diff < 30){
                    $diffIn = Carbon::parse($this->result['checkin'])->diffInMinutes($this->startHour);
                    $diffOut = Carbon::parse($this->result['checkin'])->diffInMinutes($this->endHour);
                    if($diffIn < $diffOut){
                        $this->result['checkout'] = NULL;
                    }else{
                        $this->result['checkin'] = NULL;
                    }
                }
            }
        }        

        // case when off day and don't have overtime
        if($this->workshift->isOffShift()){
            if(empty($this->overtimes)){
                $this->result['checkout'] = NULL;
                $this->result['checkin'] = NULL;
            }
        }
    }

    /**
     * Get the value of result
     */ 
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Set the value of result
     *
     * @return  self
     */ 
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }
}