<?php
namespace App\Library\SalaryComponent; 
class UangMakanLembur extends Component{
    /** senin sd jumat minimal 2 jam 
     *  sabtu minimal 5 jam
     *  minggu / hari libur minimal 4 jam
    */
    protected $code = 'UML';
    private $dataOvertime;
    private $value;

    function __construct($dataOvertime, $value)
    {
        $this->dataOvertime = $dataOvertime;
        $this->value = $value;
    }

    public function calculate(){
        $result = 0;
        if(!$this->dataOvertime) return $result;
        
        foreach($this->dataOvertime as $ot){
            $min = 2;
            $isHoliday = $ot->isHolidayOvertime();
            if(!$isHoliday){
                $isHoliday = $ot->isSundayOvertime();
            }

            if($isHoliday){
                $min = 4;
            }else{
                $isSaturday = $ot->isSaturdayOvertime();
                if($isSaturday){
                    $min = 5;
                }
            }

            $calculated = minuteToHour($ot->getRawOriginal('payroll_calculated_value'));
            if($calculated >= $min){
                $result += $this->value;
            }
        }
        return $result;
    }
}