<?php namespace Tests\Repositories;

use App\Models\Hr\GroupingPayrollEmployeeReport;
use App\Repositories\Hr\GroupingPayrollEmployeeReportRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class GroupingPayrollEmployeeReportRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var GroupingPayrollEmployeeReportRepository
     */
    protected $groupingPayrollEmployeeReportRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->groupingPayrollEmployeeReportRepo = \App::make(GroupingPayrollEmployeeReportRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->make()->toArray();

        $createdGroupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepo->create($groupingPayrollEmployeeReport);

        $createdGroupingPayrollEmployeeReport = $createdGroupingPayrollEmployeeReport->toArray();
        $this->assertArrayHasKey('id', $createdGroupingPayrollEmployeeReport);
        $this->assertNotNull($createdGroupingPayrollEmployeeReport['id'], 'Created GroupingPayrollEmployeeReport must have id specified');
        $this->assertNotNull(GroupingPayrollEmployeeReport::find($createdGroupingPayrollEmployeeReport['id']), 'GroupingPayrollEmployeeReport with given id must be in DB');
        $this->assertModelData($groupingPayrollEmployeeReport, $createdGroupingPayrollEmployeeReport);
    }

    /**
     * @test read
     */
    public function test_read_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->create();

        $dbGroupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepo->find($groupingPayrollEmployeeReport->id);

        $dbGroupingPayrollEmployeeReport = $dbGroupingPayrollEmployeeReport->toArray();
        $this->assertModelData($groupingPayrollEmployeeReport->toArray(), $dbGroupingPayrollEmployeeReport);
    }

    /**
     * @test update
     */
    public function test_update_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->create();
        $fakeGroupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->make()->toArray();

        $updatedGroupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepo->update($fakeGroupingPayrollEmployeeReport, $groupingPayrollEmployeeReport->id);

        $this->assertModelData($fakeGroupingPayrollEmployeeReport, $updatedGroupingPayrollEmployeeReport->toArray());
        $dbGroupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepo->find($groupingPayrollEmployeeReport->id);
        $this->assertModelData($fakeGroupingPayrollEmployeeReport, $dbGroupingPayrollEmployeeReport->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_grouping_payroll_employee_report()
    {
        $groupingPayrollEmployeeReport = GroupingPayrollEmployeeReport::factory()->create();

        $resp = $this->groupingPayrollEmployeeReportRepo->delete($groupingPayrollEmployeeReport->id);

        $this->assertTrue($resp);
        $this->assertNull(GroupingPayrollEmployeeReport::find($groupingPayrollEmployeeReport->id), 'GroupingPayrollEmployeeReport should not exist in DB');
    }
}
