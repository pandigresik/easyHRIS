<?php

namespace App\DataTables\FilterClass;

class NotNullKeyword
{
    private $column;

    public function __construct($name)
    {
        $this->column = $name;
    }

    public function __invoke($builder, $keyword)
    {        
        if($keyword){
            $builder->whereNotNull($this->column);
        }else{
            $builder->whereNull($this->column);
        }
    }
}
