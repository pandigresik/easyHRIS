<?php

namespace App\Http\Controllers;

use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Employee;
use Illuminate\Http\Request;
use App\Models\AlertMessage;
use App\Models\Base\Setting;
use App\Notifications\AlertNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;

class WebhookIclockController extends Controller
{
    public function index(Request $request){
        $data = $request->post('data');
        $deviceId = $request->get('deviceId');
        if(!empty($data)){
            $collect = collect($data)->groupBy(function($r){
                return $r[0];
            });
            $this->processAttendanceLog($collect, $deviceId);
        }        
    }

    private function processAttendanceLog($collect, $deviceId){
        $employee = Employee::select(['id', 'code', 'full_name'])->whereIn('code', $collect->keys())->get();
        if($employee){
            $rawMessageNotif = [];
            foreach($employee as $emp){
                $logs = $collect->get($emp->code);
                $raw = [];                
                foreach($logs as $log){
                    $raw[] = [
                        'employee_id' => $emp->id, 
                        'fingertime' => $log[1].' '.$log[2],
                        'fingerprint_device_id' => $deviceId
                    ];
                    $rawMessageNotif[] = $emp->code_name.' finger at '.$log[1].' '.$log[2];
                }                
                AttendanceLogfinger::upsert($raw, ['employee_id', 'fingertime']);                
            }

            if($rawMessageNotif){
                $messageJob = '*EasyHRIS - LJP* '.PHP_EOL.'Log Finger'.PHP_EOL.implode(PHP_EOL, $rawMessageNotif).PHP_EOL.Carbon::now()->format('j M Y H:i:s');
                $userIdTelegram = Setting::where(['type' => 'notification', 'name' => 'id_telegram'])->first();
                if($userIdTelegram){
                    if(!empty($userIdTelegram->value)){
                        Notification::route('telegram', 'easyhhris - LJP')->notify(new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
                        // Notification::send(\Auth::user(), new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
                    }
                }
            }            
        }
    }
}
