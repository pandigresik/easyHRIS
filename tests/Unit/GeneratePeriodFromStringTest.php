<?php

namespace Tests\Unit;

use Tests\TestCase;

class GeneratePeriodFromStringTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testPeriodString()
    {
        $periodString = '13 Okt 2022 - 15 Okt 2022';
        $result = generatePeriodFromString($periodString);
        $this->assertEquals('2022-10-13', $result['startDate']->format('Y-m-d'));
        $this->assertEquals('2022-10-15', $result['endDate']->format('Y-m-d'));
    }
}
