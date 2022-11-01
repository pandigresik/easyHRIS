<?php

namespace App\Http\Controllers\Hr;

use App\Repositories\Hr\PayrollPeriodRepository;


class PayrollBiweeklyPeriodController extends PayrollPeriodController
{
    /** @var  PayrollPeriodRepository */
    protected $repository;
    protected $type = 'biweekly';
    
}
