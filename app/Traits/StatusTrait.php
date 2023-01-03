<?php
namespace App\Traits;
trait StatusTrait{
    private $messageStatus = [
        'N' => 'New',
        'RV' => 'Review',
        'A' => 'Approve',
        'RJ' => 'Reject'
    ];
    public function getStatusAttribute($value){
        return $this->messageStatus[$value] ?? $value;
    }

}