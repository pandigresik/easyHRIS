<?php

namespace App\Http\Controllers;

use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Employee;
use Illuminate\Http\Request;

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
        $employee = Employee::select(['id', 'code'])->whereIn('code', $collect->keys())->get();
        if($employee){
            foreach($employee as $emp){
                $logs = $collect->get($emp->code);
                $raw = [];
                foreach($logs as $log){
                    $raw[] = [
                        'employee_id' => $emp->id, 
                        'fingertime' => $log[1],
                        'fingerprint_device_id' => $deviceId
                    ];
                }
                
                AttendanceLogfinger::upsert($raw, ['employee_id', 'fingertime']);
            }
        }
    }
}
