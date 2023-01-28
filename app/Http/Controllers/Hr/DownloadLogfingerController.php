<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\AppBaseController;
use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Employee;
use App\Models\Hr\FingerprintDevice;
use App\Repositories\Hr\FingerprintDeviceRepository;
use Carbon\Carbon;
use Rats\Zkteco\Lib\ZKTeco;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use App\Models\AlertMessage;
use App\Models\Base\Setting;
use App\Notifications\AlertNotification;
use Illuminate\Support\Facades\Notification;

class DownloadLogfingerController extends AppBaseController
{    
    private $downloadMessage = 'failed';
    public function index()
    {
        return view('hr.download_logfinger.index')->with($this->getOptionItems());
    }

    // use http stream response
    public function download($fingerprintDeviceId){
        if(!app()->runningInConsole()){
            set_time_limit(0);              // making maximum execution time unlimited
            ob_implicit_flush(1);           // Send content immediately to the browser on every statement which produces output
            ob_end_flush(); 
        }
        
        $fingerprintDevice = FingerprintDevice::find($fingerprintDeviceId);
        
        if (empty($fingerprintDevice)) {
            return $this->sendError(__('messages.not_found', ['model' => __('models/fingerprintDevices.singular')]));            
        }
        $pullMethod = env('PULL_LOGFINGER_METHOD', 'php');
        if($pullMethod == 'php'){
            $this->downloadPhp($fingerprintDevice);
        }else{
            if($pullMethod == 'exe'){
                $this->downloadExe($fingerprintDevice);
            }else{
                $this->downloadPython($fingerprintDevice);
            }
            
            (new AttendanceLogfinger())->flushCache();
        }

        $messageJob = '*EasyHRIS - LJP* '.PHP_EOL.'Download Log *'.$fingerprintDevice->display_name.'*'.PHP_EOL.$this->downloadMessage.PHP_EOL. Carbon::now()->format('j M Y H:i:s') ;
        $userIdTelegram = Setting::where(['type' => 'notification', 'name' => 'id_telegram'])->first();
        if($userIdTelegram){
            if(!empty($userIdTelegram->value)){
                Notification::route('telegram', 'easyhhris - LJP')->notify(new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
                // Notification::send(\Auth::user(), new AlertNotification(new AlertMessage($messageJob, $userIdTelegram->value)));
            }            
        }
    }

    private function downloadPhp($fingerprintDevice){
        $zk = new ZKTeco($fingerprintDevice->ip, $fingerprintDevice->port);
        $progress = ['message' => ''];
        $progress['message'] = 'Try to connecting device .....';
        echo json_encode($progress);
        if ($zk->connect()){
            $progress['message'] = 'connecting success ...';
            echo json_encode($progress);
            $attendances = $zk->getAttendance();
            $progress['message'] = 'retrieved attendance log';
            echo json_encode($progress);
            if($attendances){
                $this->insertLogFinger($attendances, $fingerprintDevice);
                $progress['message'] = 'insert data attendance to database';
            }
            $this->downloadMessage = $progress['message'];
            echo json_encode($progress);
        }else{
            \Log::error('device not connected');
            return $this->sendError('device '.$fingerprintDevice->display_name.' ('.$fingerprintDevice->ip.':'.$fingerprintDevice->port.') not connect');
        }        
    }

    private function insertLogFinger($attendances, $fingerprintDevice){
        $updateData = [];
        $userId = \Auth::id();
        $startTime = Carbon::now()->subWeek()->format('Y-m-d H:i:s');
        $employeeList = Employee::where(function($q){
            return $q->whereNull('resign_date')->orWhere('resign_date', '>=', Carbon::now()->subMonth(1));
        })->pluck('id', 'code')->toArray();
        $lastFingerTime = AttendanceLogfinger::where('fingerprint_device_id', $fingerprintDevice->id)->orderBy('fingertime', 'desc')->first();
        if($lastFingerTime){
            $startTime = $lastFingerTime->getRawOriginal('fingertime');
        }
        foreach($attendances as $attendance){
            if(isset($employeeList[$attendance['id']])){
                if($attendance['timestamp'] >= $startTime){
                    $tmp = [
                        'created_by' => $userId,
                        'employee_id' => $employeeList[$attendance['id']], 
                        'fingertime' => $attendance['timestamp'],
                        'fingerprint_device_id' => $fingerprintDevice->id
                    ];
                    $updateData[] = $tmp;
                }                
            }            
        }
        if($updateData){
            AttendanceLogfinger::upsert($updateData, ['employee_id', 'fingertime']);
        }
        
    }

    private function downloadPython($fingerprintDevice){
        $progress['message'] = 'Try to connecting device .....';
        echo json_encode($progress);
        $process = new Process(['python', 'pull_data.py', $fingerprintDevice->ip, $fingerprintDevice->port], base_path('python_script'));        
        $process->setTimeout(null);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $progress['message'] = trim($process->getOutput());
        $this->downloadMessage = $progress['message'];
        echo json_encode($progress);
    }

    private function downloadExe($fingerprintDevice){
        $progress['message'] = 'Try to connecting device .....';
        echo json_encode($progress);
        $process = new Process(['pull_data.exe', $fingerprintDevice->ip, $fingerprintDevice->port], base_path('python_script'));        
        $process->setTimeout(null);
        $process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $progress['message'] = trim($process->getOutput());
        $this->downloadMessage = $progress['message'];
        echo json_encode($progress);
    }

    private function getOptionItems()
    {
        $fingerprintDevice = (new FingerprintDeviceRepository())->all();
        return [
            'fingerprintDeviceItems' => $fingerprintDevice,
        ];        
    }
}
