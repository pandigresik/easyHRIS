<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Overtime;

class OvertimeApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_overtime()
    {
        $overtime = Overtime::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/overtimes', $overtime
        );

        $this->assertApiResponse($overtime);
    }

    /**
     * @test
     */
    public function test_read_overtime()
    {
        $overtime = Overtime::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/overtimes/'.$overtime->id
        );

        $this->assertApiResponse($overtime->toArray());
    }

    /**
     * @test
     */
    public function test_update_overtime()
    {
        $overtime = Overtime::factory()->create();
        $editedOvertime = Overtime::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/overtimes/'.$overtime->id,
            $editedOvertime
        );

        $this->assertApiResponse($editedOvertime);
    }

    /**
     * @test
     */
    public function test_delete_overtime()
    {
        $overtime = Overtime::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/overtimes/'.$overtime->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/overtimes/'.$overtime->id
        );

        $this->response->assertStatus(404);
    }
}
