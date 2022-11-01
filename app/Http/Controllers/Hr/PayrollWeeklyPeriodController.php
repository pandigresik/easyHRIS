<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\PayrollPeriodRepository;


class PayrollWeeklyPeriodController extends PayrollPeriodController
{
    /** @var  PayrollPeriodRepository */
    protected $repository;
    protected $type = 'weekly';    
    
}
