<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AlertMessage;
use App\Models\Base\Setting;
use App\Models\Hr\ShiftmentGroup;
use App\Notifications\AlertNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class GenerateWorkshiftGroup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:workshiftGroup {--period=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate workshift for shiftment group
        example: php artisan generate:workshiftGroup --period=2023-01-01__2023-01-31
        without parameter php artisan generate:workshiftGroup that automatic set period to next month,
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
        $explodePeriod = explode('__', $period);
        $params = [
            'startDate' => Carbon::parse($explodePeriod[0]),
            'endDate' => Carbon::parse($explodePeriod[1]),
            'shiftmentGroup' => ShiftmentGroup::select(['id'])->get()->pluck('id','id')->toArray()
        ];
        $controller = app()->make('App\Http\Controllers\Hr\WorkshiftGroupController');
        $controller->generateAndSave($params);
        // app()->call([$controller, 'generateAndSave'], ['input' => $params]);
        // send notification when process attendance for all employee
        $messageJob = '*EasyHRIS - LJP* '.PHP_EOL.'Generate workshift Group *'.$period.'* processed success'.PHP_EOL. Carbon::now()->format('j M Y H:i:s') ;
        $userIdTelegram = Setting::where(['type' => 'notification', 'name' => 'id_telegram'])->first();
        if($userIdTelegram){
            if(!empty($userIdTelegram->value)){
                Notification::route('telegram', 'easyhhris - LJP')->notify(new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
                    // Notification::send(\Auth::user(), new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
            }
        }
    }
}
