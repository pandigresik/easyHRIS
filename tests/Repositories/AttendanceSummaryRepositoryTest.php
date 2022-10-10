<?php namespace Tests\Repositories;

use App\Models\Hr\AttendanceSummary;
use App\Repositories\Hr\AttendanceSummaryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttendanceSummaryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AttendanceSummaryRepository
     */
    protected $attendanceSummaryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attendanceSummaryRepo = \App::make(AttendanceSummaryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->make()->toArray();

        $createdAttendanceSummary = $this->attendanceSummaryRepo->create($attendanceSummary);

        $createdAttendanceSummary = $createdAttendanceSummary->toArray();
        $this->assertArrayHasKey('id', $createdAttendanceSummary);
        $this->assertNotNull($createdAttendanceSummary['id'], 'Created AttendanceSummary must have id specified');
        $this->assertNotNull(AttendanceSummary::find($createdAttendanceSummary['id']), 'AttendanceSummary with given id must be in DB');
        $this->assertModelData($attendanceSummary, $createdAttendanceSummary);
    }

    /**
     * @test read
     */
    public function test_read_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->create();

        $dbAttendanceSummary = $this->attendanceSummaryRepo->find($attendanceSummary->id);

        $dbAttendanceSummary = $dbAttendanceSummary->toArray();
        $this->assertModelData($attendanceSummary->toArray(), $dbAttendanceSummary);
    }

    /**
     * @test update
     */
    public function test_update_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->create();
        $fakeAttendanceSummary = AttendanceSummary::factory()->make()->toArray();

        $updatedAttendanceSummary = $this->attendanceSummaryRepo->update($fakeAttendanceSummary, $attendanceSummary->id);

        $this->assertModelData($fakeAttendanceSummary, $updatedAttendanceSummary->toArray());
        $dbAttendanceSummary = $this->attendanceSummaryRepo->find($attendanceSummary->id);
        $this->assertModelData($fakeAttendanceSummary, $dbAttendanceSummary->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->create();

        $resp = $this->attendanceSummaryRepo->delete($attendanceSummary->id);

        $this->assertTrue($resp);
        $this->assertNull(AttendanceSummary::find($attendanceSummary->id), 'AttendanceSummary should not exist in DB');
    }
}
