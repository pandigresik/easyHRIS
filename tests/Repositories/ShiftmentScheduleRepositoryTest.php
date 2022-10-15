<?php namespace Tests\Repositories;

use App\Models\Hr\ShiftmentSchedule;
use App\Repositories\Hr\ShiftmentScheduleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShiftmentScheduleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ShiftmentScheduleRepository
     */
    protected $shiftmentScheduleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shiftmentScheduleRepo = \App::make(ShiftmentScheduleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->make()->toArray();

        $createdShiftmentSchedule = $this->shiftmentScheduleRepo->create($shiftmentSchedule);

        $createdShiftmentSchedule = $createdShiftmentSchedule->toArray();
        $this->assertArrayHasKey('id', $createdShiftmentSchedule);
        $this->assertNotNull($createdShiftmentSchedule['id'], 'Created ShiftmentSchedule must have id specified');
        $this->assertNotNull(ShiftmentSchedule::find($createdShiftmentSchedule['id']), 'ShiftmentSchedule with given id must be in DB');
        $this->assertModelData($shiftmentSchedule, $createdShiftmentSchedule);
    }

    /**
     * @test read
     */
    public function test_read_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->create();

        $dbShiftmentSchedule = $this->shiftmentScheduleRepo->find($shiftmentSchedule->id);

        $dbShiftmentSchedule = $dbShiftmentSchedule->toArray();
        $this->assertModelData($shiftmentSchedule->toArray(), $dbShiftmentSchedule);
    }

    /**
     * @test update
     */
    public function test_update_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->create();
        $fakeShiftmentSchedule = ShiftmentSchedule::factory()->make()->toArray();

        $updatedShiftmentSchedule = $this->shiftmentScheduleRepo->update($fakeShiftmentSchedule, $shiftmentSchedule->id);

        $this->assertModelData($fakeShiftmentSchedule, $updatedShiftmentSchedule->toArray());
        $dbShiftmentSchedule = $this->shiftmentScheduleRepo->find($shiftmentSchedule->id);
        $this->assertModelData($fakeShiftmentSchedule, $dbShiftmentSchedule->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->create();

        $resp = $this->shiftmentScheduleRepo->delete($shiftmentSchedule->id);

        $this->assertTrue($resp);
        $this->assertNull(ShiftmentSchedule::find($shiftmentSchedule->id), 'ShiftmentSchedule should not exist in DB');
    }
}
