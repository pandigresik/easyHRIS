<?php
namespace App\Library\SalaryComponent; 
class UangMakanLuarKota extends Component{
    protected $code = 'TDUM';
    private $amount;
    private $value;

    function __construct($amount, $value)
    {
        $this->amount = $amount;
        $this->value = $value;
    }
    public function calculate(){
        return 3 * $this->amount * $this->value;
    }
}