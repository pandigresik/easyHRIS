<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ProcessAttendance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:process {period} {shiftmentGroup} {--employeeId=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process attendance employee, example php artisan attendance:process 2023-01-01__2023-01-13 1,2,3,4 --employeeId=23,156';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // login as administrator
        \Auth::loginUsingId(1);
        $period = $this->argument('period');        
        $shiftmentGroup = $this->argument('shiftmentGroup');
        $employeeId = $this->option('employeeId');
        $repo = app()->make('App\Repositories\Hr\AttendanceRepository');
        $params = ['work_date_period' => $period, 'shiftment_group_id' => explode(',',$shiftmentGroup) ];
        if($employeeId){
            $params['employee_id'] = explode(',',$employeeId);
        }
        app()->call([$repo, 'create'], ['input' => $params]);
    }
}
