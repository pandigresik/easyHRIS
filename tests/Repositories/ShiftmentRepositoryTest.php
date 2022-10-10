<?php namespace Tests\Repositories;

use App\Models\Hr\Shiftment;
use App\Repositories\Hr\ShiftmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShiftmentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShiftmentRepository
     */
    protected $shiftmentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shiftmentRepo = \App::make(ShiftmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shiftment()
    {
        $shiftment = Shiftment::factory()->make()->toArray();

        $createdShiftment = $this->shiftmentRepo->create($shiftment);

        $createdShiftment = $createdShiftment->toArray();
        $this->assertArrayHasKey('id', $createdShiftment);
        $this->assertNotNull($createdShiftment['id'], 'Created Shiftment must have id specified');
        $this->assertNotNull(Shiftment::find($createdShiftment['id']), 'Shiftment with given id must be in DB');
        $this->assertModelData($shiftment, $createdShiftment);
    }

    /**
     * @test read
     */
    public function test_read_shiftment()
    {
        $shiftment = Shiftment::factory()->create();

        $dbShiftment = $this->shiftmentRepo->find($shiftment->id);

        $dbShiftment = $dbShiftment->toArray();
        $this->assertModelData($shiftment->toArray(), $dbShiftment);
    }

    /**
     * @test update
     */
    public function test_update_shiftment()
    {
        $shiftment = Shiftment::factory()->create();
        $fakeShiftment = Shiftment::factory()->make()->toArray();

        $updatedShiftment = $this->shiftmentRepo->update($fakeShiftment, $shiftment->id);

        $this->assertModelData($fakeShiftment, $updatedShiftment->toArray());
        $dbShiftment = $this->shiftmentRepo->find($shiftment->id);
        $this->assertModelData($fakeShiftment, $dbShiftment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shiftment()
    {
        $shiftment = Shiftment::factory()->create();

        $resp = $this->shiftmentRepo->delete($shiftment->id);

        $this->assertTrue($resp);
        $this->assertNull(Shiftment::find($shiftment->id), 'Shiftment should not exist in DB');
    }
}
