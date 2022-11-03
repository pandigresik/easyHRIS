<?php
namespace App\Library\SalaryComponent; 
class PotonganKehadiran extends Component{
    protected $code = 'PTHD';
    private $amountHour;
    private $amountDay;
    private $value;
    
    function __construct($amountHour, $amountDay, $value)
    {
        $this->amountDay = $amountDay;
        $this->amountHour = $amountHour;
        $this->value = $value;
    }
    
    public function calculate(){
        return ($this->amountHour * ($this->value / 7)) + ($this->amountDay * $this->value);
    }
}