<?php
namespace App\Library\SalaryComponent; 
class Overtime extends Component{
    protected $code = 'OT';
    private $amounts;   

    function __construct($amounts)
    {
        $this->amounts = $amounts;        
    }    

    public function calculate(){
        if(empty($this->amounts)) return 0;
        return array_sum($this->amounts);
    }
}