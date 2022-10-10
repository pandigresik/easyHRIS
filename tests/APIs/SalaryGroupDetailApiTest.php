<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SalaryGroupDetail;

class SalaryGroupDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/salary_group_details', $salaryGroupDetail
        );

        $this->assertApiResponse($salaryGroupDetail);
    }

    /**
     * @test
     */
    public function test_read_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/salary_group_details/'.$salaryGroupDetail->id
        );

        $this->assertApiResponse($salaryGroupDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->create();
        $editedSalaryGroupDetail = SalaryGroupDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/salary_group_details/'.$salaryGroupDetail->id,
            $editedSalaryGroupDetail
        );

        $this->assertApiResponse($editedSalaryGroupDetail);
    }

    /**
     * @test
     */
    public function test_delete_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/salary_group_details/'.$salaryGroupDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/salary_group_details/'.$salaryGroupDetail->id
        );

        $this->response->assertStatus(404);
    }
}
