<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Base\Region;

class RegionApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_region()
    {
        $region = Region::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/base/regions', $region
        );

        $this->assertApiResponse($region);
    }

    /**
     * @test
     */
    public function test_read_region()
    {
        $region = Region::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/base/regions/'.$region->id
        );

        $this->assertApiResponse($region->toArray());
    }

    /**
     * @test
     */
    public function test_update_region()
    {
        $region = Region::factory()->create();
        $editedRegion = Region::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/base/regions/'.$region->id,
            $editedRegion
        );

        $this->assertApiResponse($editedRegion);
    }

    /**
     * @test
     */
    public function test_delete_region()
    {
        $region = Region::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/base/regions/'.$region->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/base/regions/'.$region->id
        );

        $this->response->assertStatus(404);
    }
}
