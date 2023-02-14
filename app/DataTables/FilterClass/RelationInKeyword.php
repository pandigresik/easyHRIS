<?php

namespace App\DataTables\FilterClass;

class RelationInKeyword
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
        $builder->whereHas($this->relation, function ($relationQuery) use ($keyword) {
            $keyword = is_array($keyword) ? $keyword : explode(',', $keyword);
            $relationQuery->whereIn($this->column, $keyword);
        });
    }
}
