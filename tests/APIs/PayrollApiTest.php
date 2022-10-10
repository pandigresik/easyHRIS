<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Payroll;

class PayrollApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_payroll()
    {
        $payroll = Payroll::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/payrolls', $payroll
        );

        $this->assertApiResponse($payroll);
    }

    /**
     * @test
     */
    public function test_read_payroll()
    {
        $payroll = Payroll::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/payrolls/'.$payroll->id
        );

        $this->assertApiResponse($payroll->toArray());
    }

    /**
     * @test
     */
    public function test_update_payroll()
    {
        $payroll = Payroll::factory()->create();
        $editedPayroll = Payroll::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/payrolls/'.$payroll->id,
            $editedPayroll
        );

        $this->assertApiResponse($editedPayroll);
    }

    /**
     * @test
     */
    public function test_delete_payroll()
    {
        $payroll = Payroll::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/payrolls/'.$payroll->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/payrolls/'.$payroll->id
        );

        $this->response->assertStatus(404);
    }
}
