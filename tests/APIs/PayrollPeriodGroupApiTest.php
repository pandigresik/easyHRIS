<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\PayrollPeriodGroup;

class PayrollPeriodGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/payroll_period_groups', $payrollPeriodGroup
        );

        $this->assertApiResponse($payrollPeriodGroup);
    }

    /**
     * @test
     */
    public function test_read_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/payroll_period_groups/'.$payrollPeriodGroup->id
        );

        $this->assertApiResponse($payrollPeriodGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->create();
        $editedPayrollPeriodGroup = PayrollPeriodGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/payroll_period_groups/'.$payrollPeriodGroup->id,
            $editedPayrollPeriodGroup
        );

        $this->assertApiResponse($editedPayrollPeriodGroup);
    }

    /**
     * @test
     */
    public function test_delete_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/payroll_period_groups/'.$payrollPeriodGroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/payroll_period_groups/'.$payrollPeriodGroup->id
        );

        $this->response->assertStatus(404);
    }
}
