<?php
namespace App\Library\SalaryComponent; 
class UangMakan extends Component{
    protected $code = 'UM';
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