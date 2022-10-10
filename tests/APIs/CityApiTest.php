<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Base\City;

class CityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_city()
    {
        $city = City::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/base/cities', $city
        );

        $this->assertApiResponse($city);
    }

    /**
     * @test
     */
    public function test_read_city()
    {
        $city = City::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/base/cities/'.$city->id
        );

        $this->assertApiResponse($city->toArray());
    }

    /**
     * @test
     */
    public function test_update_city()
    {
        $city = City::factory()->create();
        $editedCity = City::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/base/cities/'.$city->id,
            $editedCity
        );

        $this->assertApiResponse($editedCity);
    }

    /**
     * @test
     */
    public function test_delete_city()
    {
        $city = City::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/base/cities/'.$city->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/base/cities/'.$city->id
        );

        $this->response->assertStatus(404);
    }
}
