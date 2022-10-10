<?php namespace Tests\Repositories;

use App\Models\Hr\AttendanceLogfinger;
use App\Repositories\Hr\AttendanceLogfingerRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttendanceLogfingerRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AttendanceLogfingerRepository
     */
    protected $attendanceLogfingerRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attendanceLogfingerRepo = \App::make(AttendanceLogfingerRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->make()->toArray();

        $createdAttendanceLogfinger = $this->attendanceLogfingerRepo->create($attendanceLogfinger);

        $createdAttendanceLogfinger = $createdAttendanceLogfinger->toArray();
        $this->assertArrayHasKey('id', $createdAttendanceLogfinger);
        $this->assertNotNull($createdAttendanceLogfinger['id'], 'Created AttendanceLogfinger must have id specified');
        $this->assertNotNull(AttendanceLogfinger::find($createdAttendanceLogfinger['id']), 'AttendanceLogfinger with given id must be in DB');
        $this->assertModelData($attendanceLogfinger, $createdAttendanceLogfinger);
    }

    /**
     * @test read
     */
    public function test_read_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->create();

        $dbAttendanceLogfinger = $this->attendanceLogfingerRepo->find($attendanceLogfinger->id);

        $dbAttendanceLogfinger = $dbAttendanceLogfinger->toArray();
        $this->assertModelData($attendanceLogfinger->toArray(), $dbAttendanceLogfinger);
    }

    /**
     * @test update
     */
    public function test_update_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->create();
        $fakeAttendanceLogfinger = AttendanceLogfinger::factory()->make()->toArray();

        $updatedAttendanceLogfinger = $this->attendanceLogfingerRepo->update($fakeAttendanceLogfinger, $attendanceLogfinger->id);

        $this->assertModelData($fakeAttendanceLogfinger, $updatedAttendanceLogfinger->toArray());
        $dbAttendanceLogfinger = $this->attendanceLogfingerRepo->find($attendanceLogfinger->id);
        $this->assertModelData($fakeAttendanceLogfinger, $dbAttendanceLogfinger->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->create();

        $resp = $this->attendanceLogfingerRepo->delete($attendanceLogfinger->id);

        $this->assertTrue($resp);
        $this->assertNull(AttendanceLogfinger::find($attendanceLogfinger->id), 'AttendanceLogfinger should not exist in DB');
    }
}
