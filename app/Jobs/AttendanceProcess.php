<?php

namespace App\Jobs;

use App\Models\Hr\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class AttendanceProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $employeeId;
    private $startDate;
    private $endDate;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Int $employeeId, String $startDate, String $endDate)
    {
        $this->employeeId = $employeeId;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $employee = Employee::find($this->employeeId);
        $period = implode('__',[$this->startDate,$this->endDate]);
        // attendance:process {period} {shiftmentGroup} {--employeeId=}
        Artisan::call('attendance:process',['period' => $period, 'shiftmentGroup' => $employee->shiftment_group_id, '--employeeId' => $this->employeeId]);
    }
}
