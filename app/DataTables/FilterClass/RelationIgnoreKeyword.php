<?php

namespace App\DataTables\FilterClass;

class RelationIgnoreKeyword
{
    private $column;
    private $relation;

    public function __construct($name)
    {
        list($this->relation, $this->column) = explode('.', $name);
        $this->relation = \Str::camel($this->relation);
    }

    public function __invoke($builder, $keyword)
    {
        // $builder->whereHas($this->relation, function ($relationQuery) use ($keyword) {
        //     $relationQuery->where($this->column, $keyword);
        // });
        $builder;
    }
}
