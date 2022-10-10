<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SalaryGroup;

class SalaryGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/salary_groups', $salaryGroup
        );

        $this->assertApiResponse($salaryGroup);
    }

    /**
     * @test
     */
    public function test_read_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/salary_groups/'.$salaryGroup->id
        );

        $this->assertApiResponse($salaryGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->create();
        $editedSalaryGroup = SalaryGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/salary_groups/'.$salaryGroup->id,
            $editedSalaryGroup
        );

        $this->assertApiResponse($editedSalaryGroup);
    }

    /**
     * @test
     */
    public function test_delete_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/salary_groups/'.$salaryGroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/salary_groups/'.$salaryGroup->id
        );

        $this->response->assertStatus(404);
    }
}
