<?php namespace Tests\Repositories;

use App\Models\Hr\PayrollPeriodGroup;
use App\Repositories\Hr\PayrollPeriodGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PayrollPeriodGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PayrollPeriodGroupRepository
     */
    protected $payrollPeriodGroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->payrollPeriodGroupRepo = \App::make(PayrollPeriodGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->make()->toArray();

        $createdPayrollPeriodGroup = $this->payrollPeriodGroupRepo->create($payrollPeriodGroup);

        $createdPayrollPeriodGroup = $createdPayrollPeriodGroup->toArray();
        $this->assertArrayHasKey('id', $createdPayrollPeriodGroup);
        $this->assertNotNull($createdPayrollPeriodGroup['id'], 'Created PayrollPeriodGroup must have id specified');
        $this->assertNotNull(PayrollPeriodGroup::find($createdPayrollPeriodGroup['id']), 'PayrollPeriodGroup with given id must be in DB');
        $this->assertModelData($payrollPeriodGroup, $createdPayrollPeriodGroup);
    }

    /**
     * @test read
     */
    public function test_read_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->create();

        $dbPayrollPeriodGroup = $this->payrollPeriodGroupRepo->find($payrollPeriodGroup->id);

        $dbPayrollPeriodGroup = $dbPayrollPeriodGroup->toArray();
        $this->assertModelData($payrollPeriodGroup->toArray(), $dbPayrollPeriodGroup);
    }

    /**
     * @test update
     */
    public function test_update_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->create();
        $fakePayrollPeriodGroup = PayrollPeriodGroup::factory()->make()->toArray();

        $updatedPayrollPeriodGroup = $this->payrollPeriodGroupRepo->update($fakePayrollPeriodGroup, $payrollPeriodGroup->id);

        $this->assertModelData($fakePayrollPeriodGroup, $updatedPayrollPeriodGroup->toArray());
        $dbPayrollPeriodGroup = $this->payrollPeriodGroupRepo->find($payrollPeriodGroup->id);
        $this->assertModelData($fakePayrollPeriodGroup, $dbPayrollPeriodGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payroll_period_group()
    {
        $payrollPeriodGroup = PayrollPeriodGroup::factory()->create();

        $resp = $this->payrollPeriodGroupRepo->delete($payrollPeriodGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(PayrollPeriodGroup::find($payrollPeriodGroup->id), 'PayrollPeriodGroup should not exist in DB');
    }
}
