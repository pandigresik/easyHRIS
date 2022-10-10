<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\FingerprintDevice;

class FingerprintDeviceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/fingerprint_devices', $fingerprintDevice
        );

        $this->assertApiResponse($fingerprintDevice);
    }

    /**
     * @test
     */
    public function test_read_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/fingerprint_devices/'.$fingerprintDevice->id
        );

        $this->assertApiResponse($fingerprintDevice->toArray());
    }

    /**
     * @test
     */
    public function test_update_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->create();
        $editedFingerprintDevice = FingerprintDevice::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/fingerprint_devices/'.$fingerprintDevice->id,
            $editedFingerprintDevice
        );

        $this->assertApiResponse($editedFingerprintDevice);
    }

    /**
     * @test
     */
    public function test_delete_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/fingerprint_devices/'.$fingerprintDevice->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/fingerprint_devices/'.$fingerprintDevice->id
        );

        $this->response->assertStatus(404);
    }
}
