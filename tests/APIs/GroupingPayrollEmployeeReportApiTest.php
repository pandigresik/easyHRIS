<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\GroupingPayrollEmployeeReport;

class GroupingPayrollEmployeeReportApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/grouping_payroll_employee_reports', $groupingPayrollEmployeeReport
        );

        $this->assertApiResponse($groupingPayrollEmployeeReport);
    }

    /**
     * @test
     */
    public function test_read_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/grouping_payroll_employee_reports/'.$groupingPayrollEmployeeReport->id
        );

        $this->assertApiResponse($groupingPayrollEmployeeReport->toArray());
    }

    /**
     * @test
     */
    public function test_update_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->create();
        $editedGroupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/grouping_payroll_employee_reports/'.$groupingPayrollEmployeeReport->id,
            $editedGroupingPayrollEmployeeReport
        );

        $this->assertApiResponse($editedGroupingPayrollEmployeeReport);
    }

    /**
     * @test
     */
    public function test_delete_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/grouping_payroll_employee_reports/'.$groupingPayrollEmployeeReport->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/grouping_payroll_employee_reports/'.$groupingPayrollEmployeeReport->id
        );

        $this->response->assertStatus(404);
    }
}
