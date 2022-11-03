<?php
namespace App\Library\SalaryComponent; 
class UangMakanLemburMinggu extends Component{
    protected $code = 'TUMLM';
    private $amount;
    private $value;
    
    function __construct($amount, $value)
    {
        $this->amount = $amount;
        $this->value = $value;
    }
    /*
    - < 5 jam mendapatkan 0%
    - 5 sd 6 jam mendapatkan 50%
    - >= 7 jam mendapatkan 100%
    */
    public function calculate(){
        $pengali = 0;
        if($this->amount >= 5){
            $pengali = 0.5;
        }

        if($this->amount >= 7){
            $pengali = 1;
        }
        return $pengali * $this->amount * $this->value;
    }
}