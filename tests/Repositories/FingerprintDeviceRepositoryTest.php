<?php namespace Tests\Repositories;

use App\Models\Hr\FingerprintDevice;
use App\Repositories\Hr\FingerprintDeviceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FingerprintDeviceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FingerprintDeviceRepository
     */
    protected $fingerprintDeviceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->fingerprintDeviceRepo = \App::make(FingerprintDeviceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->make()->toArray();

        $createdFingerprintDevice = $this->fingerprintDeviceRepo->create($fingerprintDevice);

        $createdFingerprintDevice = $createdFingerprintDevice->toArray();
        $this->assertArrayHasKey('id', $createdFingerprintDevice);
        $this->assertNotNull($createdFingerprintDevice['id'], 'Created FingerprintDevice must have id specified');
        $this->assertNotNull(FingerprintDevice::find($createdFingerprintDevice['id']), 'FingerprintDevice with given id must be in DB');
        $this->assertModelData($fingerprintDevice, $createdFingerprintDevice);
    }

    /**
     * @test read
     */
    public function test_read_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->create();

        $dbFingerprintDevice = $this->fingerprintDeviceRepo->find($fingerprintDevice->id);

        $dbFingerprintDevice = $dbFingerprintDevice->toArray();
        $this->assertModelData($fingerprintDevice->toArray(), $dbFingerprintDevice);
    }

    /**
     * @test update
     */
    public function test_update_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->create();
        $fakeFingerprintDevice = FingerprintDevice::factory()->make()->toArray();

        $updatedFingerprintDevice = $this->fingerprintDeviceRepo->update($fakeFingerprintDevice, $fingerprintDevice->id);

        $this->assertModelData($fakeFingerprintDevice, $updatedFingerprintDevice->toArray());
        $dbFingerprintDevice = $this->fingerprintDeviceRepo->find($fingerprintDevice->id);
        $this->assertModelData($fakeFingerprintDevice, $dbFingerprintDevice->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_fingerprint_device()
    {
        $fingerprintDevice = FingerprintDevice::factory()->create();

        $resp = $this->fingerprintDeviceRepo->delete($fingerprintDevice->id);

        $this->assertTrue($resp);
        $this->assertNull(FingerprintDevice::find($fingerprintDevice->id), 'FingerprintDevice should not exist in DB');
    }
}
