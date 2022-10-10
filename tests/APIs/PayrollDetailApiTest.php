<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\PayrollDetail;

class PayrollDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/payroll_details', $payrollDetail
        );

        $this->assertApiResponse($payrollDetail);
    }

    /**
     * @test
     */
    public function test_read_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/payroll_details/'.$payrollDetail->id
        );

        $this->assertApiResponse($payrollDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->create();
        $editedPayrollDetail = PayrollDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/payroll_details/'.$payrollDetail->id,
            $editedPayrollDetail
        );

        $this->assertApiResponse($editedPayrollDetail);
    }

    /**
     * @test
     */
    public function test_delete_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/payroll_details/'.$payrollDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/payroll_details/'.$payrollDetail->id
        );

        $this->response->assertStatus(404);
    }
}
