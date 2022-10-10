<?php namespace Tests\Repositories;

use App\Models\Hr\ShiftmentGroup;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShiftmentGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShiftmentGroupRepository
     */
    protected $shiftmentGroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shiftmentGroupRepo = \App::make(ShiftmentGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->make()->toArray();

        $createdShiftmentGroup = $this->shiftmentGroupRepo->create($shiftmentGroup);

        $createdShiftmentGroup = $createdShiftmentGroup->toArray();
        $this->assertArrayHasKey('id', $createdShiftmentGroup);
        $this->assertNotNull($createdShiftmentGroup['id'], 'Created ShiftmentGroup must have id specified');
        $this->assertNotNull(ShiftmentGroup::find($createdShiftmentGroup['id']), 'ShiftmentGroup with given id must be in DB');
        $this->assertModelData($shiftmentGroup, $createdShiftmentGroup);
    }

    /**
     * @test read
     */
    public function test_read_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->create();

        $dbShiftmentGroup = $this->shiftmentGroupRepo->find($shiftmentGroup->id);

        $dbShiftmentGroup = $dbShiftmentGroup->toArray();
        $this->assertModelData($shiftmentGroup->toArray(), $dbShiftmentGroup);
    }

    /**
     * @test update
     */
    public function test_update_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->create();
        $fakeShiftmentGroup = ShiftmentGroup::factory()->make()->toArray();

        $updatedShiftmentGroup = $this->shiftmentGroupRepo->update($fakeShiftmentGroup, $shiftmentGroup->id);

        $this->assertModelData($fakeShiftmentGroup, $updatedShiftmentGroup->toArray());
        $dbShiftmentGroup = $this->shiftmentGroupRepo->find($shiftmentGroup->id);
        $this->assertModelData($fakeShiftmentGroup, $dbShiftmentGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->create();

        $resp = $this->shiftmentGroupRepo->delete($shiftmentGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(ShiftmentGroup::find($shiftmentGroup->id), 'ShiftmentGroup should not exist in DB');
    }
}
