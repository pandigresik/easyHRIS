<?php
namespace App\Library\SalaryComponent; 
class OvertimeRegulation extends Component{
    protected $code = 'OT';
    private $amount;
    private $value;    
    private $holiday = 0;

    function __construct($amount, $value, $holiday)
    {
        $this->amount = $amount;
        $this->value = $value;
        $this->holiday = $holiday;
    }

    public function calculate(){
        return $this->holiday ? $this->calculateHoliday() : $this->calculateWorkday();
    }

    private function calculateWorkday(){
        $result = 0;
        if($this->amount > 1){
            $secondHour = $this->amount - 1;
            $result = 1.5 * $this->value + (2 * $secondHour * $this->value);
        }else{
            $result = $this->amount * $this->value;
        }
        return $result;
    }
    private function calculateHoliday(){
        $result = 0;
        if($this->amount > 7){
            $secondHour = $this->amount - 7;
            $secondHour = $secondHour > 1 ? 1 : $secondHour;
            $thirdHour = $this->amount - 8;
            $thirdHour = $thirdHour <= 0 ? 0 : $thirdHour;
            $result = 2 * 7 * $this->value + (3 * $secondHour * $this->value) + (4 * $thirdHour * $this->value);
        }else{
            $result = 2 * $this->amount * $this->value;
        }
        return $result;
    }
}