<?php
namespace App\Library\SalaryComponent; 
class TunjanganMasukHariLibur extends Component{    
    protected $code = 'TMHL';
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
            $isHoliday = $ot->isHolidayOvertime();
            if(!$isHoliday){
                $isHoliday = $ot->isSundayOvertime();
            }            
            
            if($isHoliday){
                $result += $this->value;
            }
        }
        return $result;
    }
}