<?php

namespace App\Console\Commands;

use App\Models\AlertMessage;
use App\Models\Base\Setting;
use App\Models\Hr\ShiftmentGroup;
use App\Notifications\AlertNotification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class GenerateWorkshiftEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:workshiftEmployee {--period=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate workshift employee 
        example: php artisan generate:worshiftEmployee --period=2023-01-01__2023-01-31
        without parameter php artisan generate:workshiftEmployee that automatic set period to next month,
        example current day 2023-05-16 so period is 2023-06-01__2023-06-30
        ';

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
        $period = $this->option('period');
        if(empty($period)){
            $nextMonth = Carbon::now()->addMonth();
            $period = $nextMonth->firstOfMonth()->format('Y-m-d').'__'.$nextMonth->endOfMonth()->format('Y-m-d');
        }
        
        $repo = app()->make('App\Repositories\Hr\WorkshiftRepository');
        $params = ['work_date_period' => $period, 'shiftment_group_id' => ShiftmentGroup::select(['id'])->get()->pluck('id','id')->toArray() ];
        
        app()->call([$repo, 'generateSchedule'], ['input' => $params]);
        // send notification when process attendance for all employee
        $messageJob = '*EasyHRIS - LJP* '.PHP_EOL.'Generate workshift employee *'.$period.'* processed success'.PHP_EOL. Carbon::now()->format('j M Y H:i:s') ;
        $userIdTelegram = Setting::where(['type' => 'notification', 'name' => 'id_telegram'])->first();
        if($userIdTelegram){
            if(!empty($userIdTelegram->value)){
                Notification::route('telegram', 'easyhhris - LJP')->notify(new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
                    // Notification::send(\Auth::user(), new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
            }
        }        
    }
}
