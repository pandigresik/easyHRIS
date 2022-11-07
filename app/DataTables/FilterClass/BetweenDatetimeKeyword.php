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
        $keyword[0] .= ' 00:00:00';
        if(isset($keyword[1])){
            $keyword[1] .= ' 23:23:59';
        }       
        $builder->whereBetween($this->column, $keyword);
    }
}
