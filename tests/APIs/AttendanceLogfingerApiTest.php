<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\AttendanceLogfinger;

class AttendanceLogfingerApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/attendance_logfingers', $attendanceLogfinger
        );

        $this->assertApiResponse($attendanceLogfinger);
    }

    /**
     * @test
     */
    public function test_read_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/attendance_logfingers/'.$attendanceLogfinger->id
        );

        $this->assertApiResponse($attendanceLogfinger->toArray());
    }

    /**
     * @test
     */
    public function test_update_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->create();
        $editedAttendanceLogfinger = AttendanceLogfinger::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/attendance_logfingers/'.$attendanceLogfinger->id,
            $editedAttendanceLogfinger
        );

        $this->assertApiResponse($editedAttendanceLogfinger);
    }

    /**
     * @test
     */
    public function test_delete_attendance_logfinger()
    {
        $attendanceLogfinger = AttendanceLogfinger::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/attendance_logfingers/'.$attendanceLogfinger->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/attendance_logfingers/'.$attendanceLogfinger->id
        );

        $this->response->assertStatus(404);
    }
}
