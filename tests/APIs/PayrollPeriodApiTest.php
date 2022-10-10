<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\PayrollPeriod;

class PayrollPeriodApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/payroll_periods', $payrollPeriod
        );

        $this->assertApiResponse($payrollPeriod);
    }

    /**
     * @test
     */
    public function test_read_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/payroll_periods/'.$payrollPeriod->id
        );

        $this->assertApiResponse($payrollPeriod->toArray());
    }

    /**
     * @test
     */
    public function test_update_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->create();
        $editedPayrollPeriod = PayrollPeriod::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/payroll_periods/'.$payrollPeriod->id,
            $editedPayrollPeriod
        );

        $this->assertApiResponse($editedPayrollPeriod);
    }

    /**
     * @test
     */
    public function test_delete_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/payroll_periods/'.$payrollPeriod->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/payroll_periods/'.$payrollPeriod->id
        );

        $this->response->assertStatus(404);
    }
}
