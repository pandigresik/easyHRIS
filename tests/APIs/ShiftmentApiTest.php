<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Shiftment;

class ShiftmentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shiftment()
    {
        $shiftment = Shiftment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/shiftments', $shiftment
        );

        $this->assertApiResponse($shiftment);
    }

    /**
     * @test
     */
    public function test_read_shiftment()
    {
        $shiftment = Shiftment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/shiftments/'.$shiftment->id
        );

        $this->assertApiResponse($shiftment->toArray());
    }

    /**
     * @test
     */
    public function test_update_shiftment()
    {
        $shiftment = Shiftment::factory()->create();
        $editedShiftment = Shiftment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/shiftments/'.$shiftment->id,
            $editedShiftment
        );

        $this->assertApiResponse($editedShiftment);
    }

    /**
     * @test
     */
    public function test_delete_shiftment()
    {
        $shiftment = Shiftment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/shiftments/'.$shiftment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/shiftments/'.$shiftment->id
        );

        $this->response->assertStatus(404);
    }
}
