<?php namespace Tests\Repositories;

use App\Models\Hr\RitaseDriver;
use App\Repositories\Hr\RitaseDriverRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RitaseDriverRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RitaseDriverRepository
     */
    protected $ritaseDriverRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->ritaseDriverRepo = \App::make(RitaseDriverRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->make()->toArray();

        $createdRitaseDriver = $this->ritaseDriverRepo->create($ritaseDriver);

        $createdRitaseDriver = $createdRitaseDriver->toArray();
        $this->assertArrayHasKey('id', $createdRitaseDriver);
        $this->assertNotNull($createdRitaseDriver['id'], 'Created RitaseDriver must have id specified');
        $this->assertNotNull(RitaseDriver::find($createdRitaseDriver['id']), 'RitaseDriver with given id must be in DB');
        $this->assertModelData($ritaseDriver, $createdRitaseDriver);
    }

    /**
     * @test read
     */
    public function test_read_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->create();

        $dbRitaseDriver = $this->ritaseDriverRepo->find($ritaseDriver->id);

        $dbRitaseDriver = $dbRitaseDriver->toArray();
        $this->assertModelData($ritaseDriver->toArray(), $dbRitaseDriver);
    }

    /**
     * @test update
     */
    public function test_update_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->create();
        $fakeRitaseDriver = RitaseDriver::factory()->make()->toArray();

        $updatedRitaseDriver = $this->ritaseDriverRepo->update($fakeRitaseDriver, $ritaseDriver->id);

        $this->assertModelData($fakeRitaseDriver, $updatedRitaseDriver->toArray());
        $dbRitaseDriver = $this->ritaseDriverRepo->find($ritaseDriver->id);
        $this->assertModelData($fakeRitaseDriver, $dbRitaseDriver->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->create();

        $resp = $this->ritaseDriverRepo->delete($ritaseDriver->id);

        $this->assertTrue($resp);
        $this->assertNull(RitaseDriver::find($ritaseDriver->id), 'RitaseDriver should not exist in DB');
    }
}
