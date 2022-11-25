<?php

namespace App\Http\Controllers\Hr;

use App\Models\Hr\PayrollPeriodGroup;
use App\Repositories\Hr\PayrollPeriodMonthlyRepository;


class PayrollMonthlyPeriodController extends PayrollPeriodController
{
    /** @var  PayrollPeriodMonthlyRepository */
    protected $repository;
    protected $type = 'monthly';    
    protected $routePath = 'hr.payrollMonthlyPeriods';

    public function __construct()
    {
        $this->repository = PayrollPeriodMonthlyRepository::class;        
    }

    public function create()
    {
        $this->viewPath = 'hr.payroll_monthly_periods';
        return parent::create();
    }

    protected function getOptionItems(){
        $optionParents = parent::getOptionItems();
        $periodGroups = PayrollPeriodGroup::select(['id', 'name'])->monthly()->get()->pluck('name', 'id');
        return array_merge($optionParents, [            
            'periodItems' => ['' => 'Pilih group'] + $periodGroups->toArray()
        ]);
    }
}
