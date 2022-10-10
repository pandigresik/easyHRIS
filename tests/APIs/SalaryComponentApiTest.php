<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SalaryComponent;

class SalaryComponentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/salary_components', $salaryComponent
        );

        $this->assertApiResponse($salaryComponent);
    }

    /**
     * @test
     */
    public function test_read_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/salary_components/'.$salaryComponent->id
        );

        $this->assertApiResponse($salaryComponent->toArray());
    }

    /**
     * @test
     */
    public function test_update_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->create();
        $editedSalaryComponent = SalaryComponent::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/salary_components/'.$salaryComponent->id,
            $editedSalaryComponent
        );

        $this->assertApiResponse($editedSalaryComponent);
    }

    /**
     * @test
     */
    public function test_delete_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/salary_components/'.$salaryComponent->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/salary_components/'.$salaryComponent->id
        );

        $this->response->assertStatus(404);
    }
}
