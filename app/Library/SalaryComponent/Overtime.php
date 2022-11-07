<?php
namespace App\Library\SalaryComponent; 
class Overtime extends Component{
    protected $code = 'OT';
    private $amount;
    private $value;    

    function __construct($amount, $value)
    {
        $this->amount = $amount;
        $this->value = $value;
    }    

    public function calculate(){
        return $this->amount * $this->value;
    }
}