<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Base\BusinessUnit;

class BusinessUnitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/base/business_units', $businessUnit
        );

        $this->assertApiResponse($businessUnit);
    }

    /**
     * @test
     */
    public function test_read_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/base/business_units/'.$businessUnit->id
        );

        $this->assertApiResponse($businessUnit->toArray());
    }

    /**
     * @test
     */
    public function test_update_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();
        $editedBusinessUnit = BusinessUnit::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/base/business_units/'.$businessUnit->id,
            $editedBusinessUnit
        );

        $this->assertApiResponse($editedBusinessUnit);
    }

    /**
     * @test
     */
    public function test_delete_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/base/business_units/'.$businessUnit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/base/business_units/'.$businessUnit->id
        );

        $this->response->assertStatus(404);
    }
}
