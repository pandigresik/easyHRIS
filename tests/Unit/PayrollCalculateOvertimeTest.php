<?php

namespace Tests\Unit;

use Tests\TestCase;

class PayrollCalculateOvertimeTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_under25()
    {
        $value = 24;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 0;
        $this->assertEquals($expected, $calculate) ;
    }

    public function test_equal25()
    {
        $value = 25;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 30;
        $this->assertEquals($expected, $calculate) ;
    }

    public function test_over25()
    {
        $value = 26;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 30;
        $this->assertEquals($expected, $calculate) ;
    }

    public function test_under55()
    {
        $value = 54;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 30;
        $this->assertEquals($expected, $calculate) ;
    }

    public function test_equal55()
    {
        $value = 55;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 60;
        $this->assertEquals($expected, $calculate) ;
    }

    public function test_over55()
    {
        $value = 58;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 60;
        $this->assertEquals($expected, $calculate) ;
    }

    public function test_over114()
    {
        $value = 115;
        $calculate = payrollCalculatedOvertimeValue($value);
        $expected = 120;
        $this->assertEquals($expected, $calculate) ;
    }
}
