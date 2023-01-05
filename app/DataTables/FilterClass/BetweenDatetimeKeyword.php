<?php

namespace App\DataTables\FilterClass;

class BetweenDatetimeKeyword
{
    private $column;

    public function __construct($name)
    {
        $this->column = $name;
    }

    public function __invoke($builder, $keyword)
    {
        $separator = '__';
        if (is_string($keyword)) {
            $keyword = -1 !== strpos($keyword, $separator) ? explode($separator, $keyword) : $keyword;
        }

        $keyword = is_array($keyword) ? $keyword : [$keyword];        
        $keyword[0] = $this->setStartTimeValue($keyword[0]);
        if(isset($keyword[1])){
            $keyword[1] = $this->setEndTimeValue($keyword[1]);            
        }       
        $builder->whereBetween($this->column, $keyword);
    }

    private function hasTimeValue($value){
        return \Str::contains($value, ':');
    }

    private function setStartTimeValue($value){
        if($this->hasTimeValue($value)) return $value;
        return $value .= ' 00:00:00';
    }

    private function setEndTimeValue($value){
        if($this->hasTimeValue($value)) return $value;
        return $value .= ' 23:23:59';
    }
}
