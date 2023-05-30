<?php

namespace App\DataTables\FilterClass;

class BiggerNolKeyword
{
    private $column;

    public function __construct($name)
    {
        $this->column = $name;
    }

    public function __invoke($builder, $keyword)
    {        
        if($keyword){
            $builder->where($this->column, '>', 0);
        }else{
            $builder->where($this->column, '<=', 0);
        }
    }
}
