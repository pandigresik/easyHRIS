<?php

namespace App\Http\Controllers\Hr;

use App\Models\Hr\SalaryComponent;
use App\Repositories\Hr\PayrollPeriodRepository;


class PayrollBiweeklyPeriodController extends PayrollPeriodController
{
    /** @var  PayrollPeriodRepository */
    protected $repository;
    protected $type = 'biweekly';    
    protected $routePath = 'hr.payrollBiweeklyPeriods';
    
    
    /**
     * Show the form for creating a new PayrollPeriod.
     *
     * @return Response
     */
    public function create()
    {
        $this->viewPath = 'hr.payroll_biweekly_periods';
        return parent::create();
    }

    protected function getOptionItems(){
        $optionParents = parent::getOptionItems();
        return array_merge($optionParents, [
            'bpjsFees' => SalaryComponent::whereIn('id', config('local.bpjs_fee'))->get()->pluck('name', 'id')->toArray()
        ]);
    }
}
