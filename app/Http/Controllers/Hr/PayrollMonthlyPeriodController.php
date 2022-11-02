<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\PayrollPeriodRepository;


class PayrollMonthlyPeriodController extends PayrollPeriodController
{
    /** @var  PayrollPeriodRepository */
    protected $repository;
    protected $type = 'monthly';    
    protected $routePath = 'hr.payrollMonthlyPeriods';

}
