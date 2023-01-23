<?php

namespace Tests\Unit;

use App\Library\Formula\OvertimeDay;
use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Overtime;
use App\Models\Hr\Workshift;
use Tests\TestCase;

class CalculateOvertimeTest extends TestCase
{
    private $constraint = ['min' => 120, 'max' => 240];
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // lembur sebelum jam kerja awal
    public function test_lemburawal()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 16:00:45']))->syncOriginal()
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '07:00:00', 'end_hour' => '08:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => '2022-10-10 16:00:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '07:00:00', 
                    'end_hour' => '08:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '06:50:00',
                    'end_hour_real' => '08:00:00',
                    'raw_value' => 70,
                    'calculated_value' => 60
                ]))->toArray()
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();        
        $this->assertEquals($expected, $result);
    }
    // lembur di jam istirahat
    public function test_lemburtengah_lengkap()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 07:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 16:00:45']))->syncOriginal()
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '12:00:00', 'end_hour' => '13:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 07:50:00',
            'checkout' => '2022-10-10 16:00:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '12:00:00', 
                    'end_hour' => '13:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '12:00:00',
                    'end_hour_real' => '13:00:00',
                    'raw_value' => 60,
                    'calculated_value' => 60
                ]))->toArray()
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();        
        $this->assertEquals($expected, $result);
    }

    public function test_lemburakhir_lengkap()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 12:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 14:00:45']))->syncOriginal()
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '13:00:00', 'end_hour' => '14:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => '2022-10-10 14:00:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '13:00:00', 
                    'end_hour' => '14:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0,
                    'start_hour_real' => '13:00:00',
                    'end_hour_real' => '14:00:45',
                    'raw_value' => 60,
                    'calculated_value' => 60
                ]))->toArray()
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();        
        $this->assertEquals($expected, $result);
    }

    public function test_lemburawaltengah_lengkap()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 16:00:45']))->syncOriginal()
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '07:00:00', 'end_hour' => '08:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal(),
            (new Overtime(['start_hour' => '12:00:00', 'end_hour' => '13:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => '2022-10-10 16:00:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '07:00:00', 
                    'end_hour' => '08:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '06:50:00',
                    'end_hour_real' => '08:00:00',
                    'raw_value' => 70,
                    'calculated_value' => 60
                ]))->toArray(),
                (new Overtime([
                    'start_hour' => '12:00:00', 
                    'end_hour' => '13:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '12:00:00',
                    'end_hour_real' => '13:00:00',
                    'raw_value' => 60,
                    'calculated_value' => 60
                ]))->toArray()
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();        
        $this->assertEquals($expected, $result);
    }

    public function test_lemburawaltengahakhir_lengkap()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 17:10:45']))->syncOriginal()
        ];
        // data lembur
        $overtimes = [
            (new Overtime(['start_hour' => '07:00:00', 'end_hour' => '08:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal(),
            (new Overtime(['start_hour' => '12:00:00', 'end_hour' => '13:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal(),
            (new Overtime(['start_hour' => '16:00:00', 'end_hour' => '17:00:00', 'breaktime_value' => 20, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => '2022-10-10 17:10:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '07:00:00', 
                    'end_hour' => '08:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '06:50:00',
                    'end_hour_real' => '08:00:00',
                    'raw_value' => 70,
                    'calculated_value' => 60
                ]))->toArray(),
                (new Overtime([
                    'start_hour' => '12:00:00', 
                    'end_hour' => '13:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '12:00:00',
                    'end_hour_real' => '13:00:00',
                    'raw_value' => 60,
                    'calculated_value' => 60
                ]))->toArray(),
                (new Overtime([
                    'start_hour' => '16:00:00', 
                    'end_hour' => '17:00:00', 
                    'breaktime_value' => 20, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '16:00:00',
                    'end_hour_real' => '17:10:45',
                    'raw_value' => 70,
                    'calculated_value' => 40
                ]))->toArray(),
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();        
        $this->assertEquals($expected, $result);
    }

    public function test_lemburawalakhir_lengkap()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 17:10:45']))->syncOriginal()
        ];
        // data lembur
        $overtimes = [
            (new Overtime(['start_hour' => '07:00:00', 'end_hour' => '08:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal(),            
            (new Overtime(['start_hour' => '16:00:00', 'end_hour' => '17:00:00', 'breaktime_value' => 20, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => '2022-10-10 17:10:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '07:00:00', 
                    'end_hour' => '08:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '06:50:00',
                    'end_hour_real' => '08:00:00',
                    'raw_value' => 70,
                    'calculated_value' => 60
                ]))->toArray(),                
                (new Overtime([
                    'start_hour' => '16:00:00', 
                    'end_hour' => '17:00:00', 
                    'breaktime_value' => 20, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '16:00:00',
                    'end_hour_real' => '17:10:45',
                    'raw_value' => 70,
                    'calculated_value' => 40
                ]))->toArray(),
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();        
        $this->assertEquals($expected, $result);
    }

    public function test_lemburakhirlupafingerpulang_lengkap()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:53:00']))->syncOriginal(),            
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '16:00:00', 'end_hour' => '19:30:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0, 'start_hour_real' => null, 'end_hour_real' => null, 'raw_value' => null, 'calculated_value' => null]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => NULL,
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '16:00:00', 
                    'end_hour' => '19:30:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0,
                    'start_hour_real' => null,
                    'end_hour_real' => null,
                    'raw_value' => null,
                    'calculated_value' => null
                ]))->toArray()
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();
        $this->assertEquals($expected, $result);
    }

    public function test_pulangakhir_tanpalembur()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 08:00:59', 'end_hour' => '2022-10-10 15:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 06:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 19:53:00']))->syncOriginal(),            
        ];
        $overtimes = [];
        
        $expected = [
            'checkin' => '2022-10-10 06:50:00',
            'checkout' => '2022-10-10 19:53:00',
            'overtimes' => []
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();
        $this->assertEquals($expected, $result);
    }

    public function test_lembur_harilibur()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-10 00:00:00', 'end_hour' => '2022-10-10 00:00:00', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 08:15:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 15:45:00']))->syncOriginal(),            
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '08:00:00', 'end_hour' => '16:00:00', 'breaktime_value' => 60, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 08:15:00',
            'checkout' => '2022-10-10 15:45:00',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '08:00:00', 
                    'end_hour' => '16:00:00', 
                    'breaktime_value' => 60, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0,
                    'start_hour_real' => '08:15:00',
                    'end_hour_real' => '15:45:00',
                    'raw_value' => 450,
                    'calculated_value' => 390 
                ]))->toArray()
            ]
        ];
        $overday = new OvertimeDay($workshift, $logFingers, $overtimes, $this->constraint);
        $result = $overday->getResult();
        $result['overtimes'] = collect($result['overtimes'])->map(function($item){
            return $item->toArray();
        })->toArray();
        $this->assertEquals($expected, $result);
    }
}
