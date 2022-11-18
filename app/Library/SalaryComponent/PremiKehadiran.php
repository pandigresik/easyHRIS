<?php
namespace App\Library\SalaryComponent; 
class PremiKehadiran extends Component{
    protected $code = 'PRHD';
    private $amount;
    private $offCount = 0;
    private $value;
    /** jumlah tidak masuk, ijin dan terlambat */
    private $absentCount = 0;

    function __construct($amount, $value, $absentCount, $offCount)
    {
        $this->amount = $amount;
        $this->value = $value;
        $this->absentCount = $absentCount;
        $this->offCount = $offCount;
    }
    /*
    absentCount :
    1 potongan 25%
    2 potongan 50%
    3 potongan 100%
    */
    public function calculate(){
        $pengurang = 0;
        if($this->absentCount >= 1){
            $pengurang = 0.25;
        }

        if($this->absentCount >= 2){
            $pengurang = 0.5;
        }

        if($this->absentCount >= 3){
            $pengurang = 1;
        }
        $premiDefault = $this->amount * $this->value;
        $premiMinus = $this->value  * $this->offCount;
        $premiAmount = $premiDefault - $premiMinus;
        return  $premiAmount - ($pengurang * $premiAmount);
    }
}