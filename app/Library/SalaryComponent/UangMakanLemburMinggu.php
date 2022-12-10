<?php
namespace App\Library\SalaryComponent; 
class UangMakanLemburMinggu extends Component{
    protected $code = 'TUMLM';
    private $amounts = [];
    private $value;
    
    function __construct($amounts, $value)
    {
        $this->amounts = $amounts;
        $this->value = $value;
    }
    /*
    - < 5 jam mendapatkan 0%
    - 5 sd 6 jam mendapatkan 50%
    - >= 7 jam mendapatkan 100%
    */
    public function calculate(){
        $result = 0;
        if(empty($this->amounts)) return 0;

        foreach($this->amounts as $amount){
            $result += $this->calculateDay($amount);
        }
        return $result;
    }

    private function calculateDay($amount){
        $pengali = 0;
        if($amount >= 5){
            $pengali = 0.5;
        }

        if($amount >= 7){
            $pengali = 1;
        }
        return $pengali * $this->value;
    }
}