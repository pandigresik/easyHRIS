<?php
namespace App\Library\SalaryComponent; 
class DoubleRitase extends Component{
    protected $code = 'TDDRT';
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