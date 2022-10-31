<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\RequestWorkshift;

class RequestWorkshiftApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/request_workshifts', $requestWorkshift
        );

        $this->assertApiResponse($requestWorkshift);
    }

    /**
     * @test
     */
    public function test_read_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/request_workshifts/'.$requestWorkshift->id
        );

        $this->assertApiResponse($requestWorkshift->toArray());
    }

    /**
     * @test
     */
    public function test_update_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->create();
        $editedRequestWorkshift = RequestWorkshift::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/request_workshifts/'.$requestWorkshift->id,
            $editedRequestWorkshift
        );

        $this->assertApiResponse($editedRequestWorkshift);
    }

    /**
     * @test
     */
    public function test_delete_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/request_workshifts/'.$requestWorkshift->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/request_workshifts/'.$requestWorkshift->id
        );

        $this->response->assertStatus(404);
    }
}
