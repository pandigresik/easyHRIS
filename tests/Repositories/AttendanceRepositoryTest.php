<?php namespace Tests\Repositories;

use App\Models\Hr\Attendance;
use App\Repositories\Hr\AttendanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AttendanceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AttendanceRepository
     */
    protected $attendanceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->attendanceRepo = \App::make(AttendanceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_attendance()
    {
        $attendance = Attendance::factory()->make()->toArray();

        $createdAttendance = $this->attendanceRepo->create($attendance);

        $createdAttendance = $createdAttendance->toArray();
        $this->assertArrayHasKey('id', $createdAttendance);
        $this->assertNotNull($createdAttendance['id'], 'Created Attendance must have id specified');
        $this->assertNotNull(Attendance::find($createdAttendance['id']), 'Attendance with given id must be in DB');
        $this->assertModelData($attendance, $createdAttendance);
    }

    /**
     * @test read
     */
    public function test_read_attendance()
    {
        $attendance = Attendance::factory()->create();

        $dbAttendance = $this->attendanceRepo->find($attendance->id);

        $dbAttendance = $dbAttendance->toArray();
        $this->assertModelData($attendance->toArray(), $dbAttendance);
    }

    /**
     * @test update
     */
    public function test_update_attendance()
    {
        $attendance = Attendance::factory()->create();
        $fakeAttendance = Attendance::factory()->make()->toArray();

        $updatedAttendance = $this->attendanceRepo->update($fakeAttendance, $attendance->id);

        $this->assertModelData($fakeAttendance, $updatedAttendance->toArray());
        $dbAttendance = $this->attendanceRepo->find($attendance->id);
        $this->assertModelData($fakeAttendance, $dbAttendance->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_attendance()
    {
        $attendance = Attendance::factory()->create();

        $resp = $this->attendanceRepo->delete($attendance->id);

        $this->assertTrue($resp);
        $this->assertNull(Attendance::find($attendance->id), 'Attendance should not exist in DB');
    }
}
