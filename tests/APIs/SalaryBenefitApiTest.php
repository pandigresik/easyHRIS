<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SalaryBenefit;

class SalaryBenefitApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/salary_benefits', $salaryBenefit
        );

        $this->assertApiResponse($salaryBenefit);
    }

    /**
     * @test
     */
    public function test_read_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/salary_benefits/'.$salaryBenefit->id
        );

        $this->assertApiResponse($salaryBenefit->toArray());
    }

    /**
     * @test
     */
    public function test_update_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->create();
        $editedSalaryBenefit = SalaryBenefit::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/salary_benefits/'.$salaryBenefit->id,
            $editedSalaryBenefit
        );

        $this->assertApiResponse($editedSalaryBenefit);
    }

    /**
     * @test
     */
    public function test_delete_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/salary_benefits/'.$salaryBenefit->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/salary_benefits/'.$salaryBenefit->id
        );

        $this->response->assertStatus(404);
    }
}
