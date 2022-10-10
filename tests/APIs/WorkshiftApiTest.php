<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Workshift;

class WorkshiftApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_workshift()
    {
        $workshift = Workshift::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/workshifts', $workshift
        );

        $this->assertApiResponse($workshift);
    }

    /**
     * @test
     */
    public function test_read_workshift()
    {
        $workshift = Workshift::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/workshifts/'.$workshift->id
        );

        $this->assertApiResponse($workshift->toArray());
    }

    /**
     * @test
     */
    public function test_update_workshift()
    {
        $workshift = Workshift::factory()->create();
        $editedWorkshift = Workshift::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/workshifts/'.$workshift->id,
            $editedWorkshift
        );

        $this->assertApiResponse($editedWorkshift);
    }

    /**
     * @test
     */
    public function test_delete_workshift()
    {
        $workshift = Workshift::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/workshifts/'.$workshift->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/workshifts/'.$workshift->id
        );

        $this->response->assertStatus(404);
    }
}
