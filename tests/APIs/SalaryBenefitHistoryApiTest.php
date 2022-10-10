<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SalaryBenefitHistory;

class SalaryBenefitHistoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/salary_benefit_histories', $salaryBenefitHistory
        );

        $this->assertApiResponse($salaryBenefitHistory);
    }

    /**
     * @test
     */
    public function test_read_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/salary_benefit_histories/'.$salaryBenefitHistory->id
        );

        $this->assertApiResponse($salaryBenefitHistory->toArray());
    }

    /**
     * @test
     */
    public function test_update_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->create();
        $editedSalaryBenefitHistory = SalaryBenefitHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/salary_benefit_histories/'.$salaryBenefitHistory->id,
            $editedSalaryBenefitHistory
        );

        $this->assertApiResponse($editedSalaryBenefitHistory);
    }

    /**
     * @test
     */
    public function test_delete_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/salary_benefit_histories/'.$salaryBenefitHistory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/salary_benefit_histories/'.$salaryBenefitHistory->id
        );

        $this->response->assertStatus(404);
    }
}
