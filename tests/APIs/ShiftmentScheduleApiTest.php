<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\ShiftmentSchedule;

class ShiftmentScheduleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/shiftment_schedules', $shiftmentSchedule
        );

        $this->assertApiResponse($shiftmentSchedule);
    }

    /**
     * @test
     */
    public function test_read_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/shiftment_schedules/'.$shiftmentSchedule->id
        );

        $this->assertApiResponse($shiftmentSchedule->toArray());
    }

    /**
     * @test
     */
    public function test_update_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->create();
        $editedShiftmentSchedule = ShiftmentSchedule::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/shiftment_schedules/'.$shiftmentSchedule->id,
            $editedShiftmentSchedule
        );

        $this->assertApiResponse($editedShiftmentSchedule);
    }

    /**
     * @test
     */
    public function test_delete_shiftment_schedule()
    {
        $shiftmentSchedule = ShiftmentSchedule::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/shiftment_schedules/'.$shiftmentSchedule->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/shiftment_schedules/'.$shiftmentSchedule->id
        );

        $this->response->assertStatus(404);
    }
}
