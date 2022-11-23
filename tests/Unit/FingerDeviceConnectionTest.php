<?php

namespace Tests\Unit;

use Rats\Zkteco\Lib\ZKTeco;
use Tests\TestCase;

class FingerDeviceConnectionTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_connection()
    {
        // '192.168.1.202' success, finger lainnya gagal connect
        $zk = new ZKTeco('192.168.1.245');        
        $this->assertTrue($zk->connect(), 'device connected success');
    }
}
