<?php
namespace App\Library\SalaryComponent; 
class GajiPokokHarian extends Component{
    protected $code = 'GPH';
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