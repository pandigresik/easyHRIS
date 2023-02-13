<?php

namespace App\DataTables\FilterClass;

class PayrollEntityGroupKeyword
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
            $relationQuery->whereIn('id', function($r) use ($keyword){                
                $r->select('employee_id')->from('grouping_payroll_employee_report')->whereRaw('grouping_payroll_entity_id in ('.$keyword.')');
            });
        });
    }
}
