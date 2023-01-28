<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class DownloadAttendanceLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendanceLog:download {deviceId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download log finger based on fingerprint device';

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
        Auth::loginUsingId(1);
        $deviceId = $this->argument('deviceId');
        $controller = app()->make('App\Http\Controllers\Hr\DownloadLogfingerController');
        app()->call([$controller, 'download'], ['fingerprintDeviceId' => $deviceId]);                
    }
}
