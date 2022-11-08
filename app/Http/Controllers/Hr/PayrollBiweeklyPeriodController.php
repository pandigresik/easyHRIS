<?php

namespace App\Http\Controllers\Hr;

use App\Models\Hr\PayrollPeriodGroup;
use App\Models\Hr\SalaryComponent;
use App\Repositories\Hr\PayrollPeriodBiweeklyRepository;


class PayrollBiweeklyPeriodController extends PayrollPeriodController
{
    /** @var  PayrollPeriodBiweeklyRepository */
    protected $repository;
    protected $type = 'biweekly';    
    protected $routePath = 'hr.payrollBiweeklyPeriods';
    
    public function __construct()
    {
        $this->repository = PayrollPeriodBiweeklyRepository::class;        
    }    
    
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
        $periodGroups = PayrollPeriodGroup::select(['id', 'name'])->biweekly()->get()->pluck('name', 'id');
        return array_merge($optionParents, [
            'bpjsFees' => SalaryComponent::whereIn('id', config('local.bpjs_fee'))->get()->pluck('name', 'id')->toArray(),
            'periodItems' => ['' => 'Pilih group'] + $periodGroups->toArray()
        ]);
    }
}
