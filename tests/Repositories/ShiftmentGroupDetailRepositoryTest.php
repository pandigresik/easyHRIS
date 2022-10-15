<?php namespace Tests\Repositories;

use App\Models\Hr\ShiftmentGroupDetail;
use App\Repositories\Hr\ShiftmentGroupDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShiftmentGroupDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShiftmentGroupDetailRepository
     */
    protected $shiftmentGroupDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shiftmentGroupDetailRepo = \App::make(ShiftmentGroupDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->make()->toArray();

        $createdShiftmentGroupDetail = $this->shiftmentGroupDetailRepo->create($shiftmentGroupDetail);

        $createdShiftmentGroupDetail = $createdShiftmentGroupDetail->toArray();
        $this->assertArrayHasKey('id', $createdShiftmentGroupDetail);
        $this->assertNotNull($createdShiftmentGroupDetail['id'], 'Created ShiftmentGroupDetail must have id specified');
        $this->assertNotNull(ShiftmentGroupDetail::find($createdShiftmentGroupDetail['id']), 'ShiftmentGroupDetail with given id must be in DB');
        $this->assertModelData($shiftmentGroupDetail, $createdShiftmentGroupDetail);
    }

    /**
     * @test read
     */
    public function test_read_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->create();

        $dbShiftmentGroupDetail = $this->shiftmentGroupDetailRepo->find($shiftmentGroupDetail->id);

        $dbShiftmentGroupDetail = $dbShiftmentGroupDetail->toArray();
        $this->assertModelData($shiftmentGroupDetail->toArray(), $dbShiftmentGroupDetail);
    }

    /**
     * @test update
     */
    public function test_update_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->create();
        $fakeShiftmentGroupDetail = ShiftmentGroupDetail::factory()->make()->toArray();

        $updatedShiftmentGroupDetail = $this->shiftmentGroupDetailRepo->update($fakeShiftmentGroupDetail, $shiftmentGroupDetail->id);

        $this->assertModelData($fakeShiftmentGroupDetail, $updatedShiftmentGroupDetail->toArray());
        $dbShiftmentGroupDetail = $this->shiftmentGroupDetailRepo->find($shiftmentGroupDetail->id);
        $this->assertModelData($fakeShiftmentGroupDetail, $dbShiftmentGroupDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->create();

        $resp = $this->shiftmentGroupDetailRepo->delete($shiftmentGroupDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(ShiftmentGroupDetail::find($shiftmentGroupDetail->id), 'ShiftmentGroupDetail should not exist in DB');
    }
}
