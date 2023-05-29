<?php

namespace Tests\Unit;

use App\Library\Formula\OvertimeDay;
use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Overtime;
use App\Models\Hr\Workshift;
use Tests\TestCase;

class CalculateOvertimeShift3Test extends TestCase
{
    private $constraint = ['min' => 120, 'max' => 120];
    /**
     * A basic unit test example.
     *
     * @return void
     */
    // lembur sebelum shift3 jam kerja awal, untuk lembur shift 3 absent di hari berikutnya jika diawali jam 00:00:59
    public function test_lemburawal()
    {
        $workshift = new Workshift(['start_hour' => '2022-10-11 00:00:59', 'end_hour' => '2022-10-11 07:59:59', 'work_date' => '2022-10-10']);
        $workshift->syncOriginal();
        $logFingers = [
            (new AttendanceLogfinger(['fingertime' => '2022-10-10 21:50:00']))->syncOriginal(),
            (new AttendanceLogfinger(['fingertime' => '2022-10-11 08:00:45']))->syncOriginal()
        ];
        $overtimes = [
            (new Overtime(['start_hour' => '22:00:00', 'end_hour' => '00:00:00', 'breaktime_value' => 0, 'overtime_date' => '2022-10-10', 'overday' => 0]))->syncOriginal()
        ];
        
        $expected = [
            'checkin' => '2022-10-10 21:50:00',
            'checkout' => '2022-10-11 08:00:45',
            'overtimes' => [
                (new Overtime([
                    'start_hour' => '22:00:00', 
                    'end_hour' => '00:00:00', 
                    'breaktime_value' => 0, 
                    'overtime_date' => '2022-10-10', 
                    'overday' => 0, 
                    'start_hour_real' => '21:50:00',
                    'end_hour_real' => '00:00:00',
                    'raw_value' => 130,
                    'calculated_value' => 120,
                    'payroll_calculated_value' => 120
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
