<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\AttendanceSummary;

class AttendanceSummaryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/attendance_summaries', $attendanceSummary
        );

        $this->assertApiResponse($attendanceSummary);
    }

    /**
     * @test
     */
    public function test_read_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/attendance_summaries/'.$attendanceSummary->id
        );

        $this->assertApiResponse($attendanceSummary->toArray());
    }

    /**
     * @test
     */
    public function test_update_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->create();
        $editedAttendanceSummary = AttendanceSummary::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/attendance_summaries/'.$attendanceSummary->id,
            $editedAttendanceSummary
        );

        $this->assertApiResponse($editedAttendanceSummary);
    }

    /**
     * @test
     */
    public function test_delete_attendance_summary()
    {
        $attendanceSummary = AttendanceSummary::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/attendance_summaries/'.$attendanceSummary->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/attendance_summaries/'.$attendanceSummary->id
        );

        $this->response->assertStatus(404);
    }
}
