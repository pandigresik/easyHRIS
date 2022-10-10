<?php namespace Tests\Repositories;

use App\Models\Hr\PayrollPeriod;
use App\Repositories\Hr\PayrollPeriodRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PayrollPeriodRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PayrollPeriodRepository
     */
    protected $payrollPeriodRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->payrollPeriodRepo = \App::make(PayrollPeriodRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->make()->toArray();

        $createdPayrollPeriod = $this->payrollPeriodRepo->create($payrollPeriod);

        $createdPayrollPeriod = $createdPayrollPeriod->toArray();
        $this->assertArrayHasKey('id', $createdPayrollPeriod);
        $this->assertNotNull($createdPayrollPeriod['id'], 'Created PayrollPeriod must have id specified');
        $this->assertNotNull(PayrollPeriod::find($createdPayrollPeriod['id']), 'PayrollPeriod with given id must be in DB');
        $this->assertModelData($payrollPeriod, $createdPayrollPeriod);
    }

    /**
     * @test read
     */
    public function test_read_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->create();

        $dbPayrollPeriod = $this->payrollPeriodRepo->find($payrollPeriod->id);

        $dbPayrollPeriod = $dbPayrollPeriod->toArray();
        $this->assertModelData($payrollPeriod->toArray(), $dbPayrollPeriod);
    }

    /**
     * @test update
     */
    public function test_update_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->create();
        $fakePayrollPeriod = PayrollPeriod::factory()->make()->toArray();

        $updatedPayrollPeriod = $this->payrollPeriodRepo->update($fakePayrollPeriod, $payrollPeriod->id);

        $this->assertModelData($fakePayrollPeriod, $updatedPayrollPeriod->toArray());
        $dbPayrollPeriod = $this->payrollPeriodRepo->find($payrollPeriod->id);
        $this->assertModelData($fakePayrollPeriod, $dbPayrollPeriod->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payroll_period()
    {
        $payrollPeriod = PayrollPeriod::factory()->create();

        $resp = $this->payrollPeriodRepo->delete($payrollPeriod->id);

        $this->assertTrue($resp);
        $this->assertNull(PayrollPeriod::find($payrollPeriod->id), 'PayrollPeriod should not exist in DB');
    }
}
