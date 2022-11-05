<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\RitaseDriver;

class RitaseDriverApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/ritase_drivers', $ritaseDriver
        );

        $this->assertApiResponse($ritaseDriver);
    }

    /**
     * @test
     */
    public function test_read_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/ritase_drivers/'.$ritaseDriver->id
        );

        $this->assertApiResponse($ritaseDriver->toArray());
    }

    /**
     * @test
     */
    public function test_update_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->create();
        $editedRitaseDriver = RitaseDriver::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/ritase_drivers/'.$ritaseDriver->id,
            $editedRitaseDriver
        );

        $this->assertApiResponse($editedRitaseDriver);
    }

    /**
     * @test
     */
    public function test_delete_ritase_driver()
    {
        $ritaseDriver = RitaseDriver::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/ritase_drivers/'.$ritaseDriver->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/ritase_drivers/'.$ritaseDriver->id
        );

        $this->response->assertStatus(404);
    }
}
