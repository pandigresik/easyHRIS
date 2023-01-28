<?php

namespace App\Console\Commands;

use App\Models\Hr\ShiftmentGroup;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ProcessAttendanceDaily extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:processDaily {--date=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process attendance employee daily, example php artisan attendance:processDaily 2023-01-01';

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
        $date = $this->option('date');
        if(empty($date)){
            $date = Carbon::now()->subDays(1)->format('Y-m-d');
        }
        $hiftment = ShiftmentGroup::get()->pluck('id')->join(',');
        $this->call('attendance:process', [
            'period' => implode('__',[$date, $date]),
            'shiftmentGroup' => $hiftment
        ]);                
    }
}
