<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SalaryAllowance;

class SalaryAllowanceApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/salary_allowances', $salaryAllowance
        );

        $this->assertApiResponse($salaryAllowance);
    }

    /**
     * @test
     */
    public function test_read_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/salary_allowances/'.$salaryAllowance->id
        );

        $this->assertApiResponse($salaryAllowance->toArray());
    }

    /**
     * @test
     */
    public function test_update_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->create();
        $editedSalaryAllowance = SalaryAllowance::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/salary_allowances/'.$salaryAllowance->id,
            $editedSalaryAllowance
        );

        $this->assertApiResponse($editedSalaryAllowance);
    }

    /**
     * @test
     */
    public function test_delete_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/salary_allowances/'.$salaryAllowance->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/salary_allowances/'.$salaryAllowance->id
        );

        $this->response->assertStatus(404);
    }
}
