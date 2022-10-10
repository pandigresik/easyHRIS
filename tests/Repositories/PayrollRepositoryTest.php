<?php namespace Tests\Repositories;

use App\Models\Hr\Payroll;
use App\Repositories\Hr\PayrollRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PayrollRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PayrollRepository
     */
    protected $payrollRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->payrollRepo = \App::make(PayrollRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payroll()
    {
        $payroll = Payroll::factory()->make()->toArray();

        $createdPayroll = $this->payrollRepo->create($payroll);

        $createdPayroll = $createdPayroll->toArray();
        $this->assertArrayHasKey('id', $createdPayroll);
        $this->assertNotNull($createdPayroll['id'], 'Created Payroll must have id specified');
        $this->assertNotNull(Payroll::find($createdPayroll['id']), 'Payroll with given id must be in DB');
        $this->assertModelData($payroll, $createdPayroll);
    }

    /**
     * @test read
     */
    public function test_read_payroll()
    {
        $payroll = Payroll::factory()->create();

        $dbPayroll = $this->payrollRepo->find($payroll->id);

        $dbPayroll = $dbPayroll->toArray();
        $this->assertModelData($payroll->toArray(), $dbPayroll);
    }

    /**
     * @test update
     */
    public function test_update_payroll()
    {
        $payroll = Payroll::factory()->create();
        $fakePayroll = Payroll::factory()->make()->toArray();

        $updatedPayroll = $this->payrollRepo->update($fakePayroll, $payroll->id);

        $this->assertModelData($fakePayroll, $updatedPayroll->toArray());
        $dbPayroll = $this->payrollRepo->find($payroll->id);
        $this->assertModelData($fakePayroll, $dbPayroll->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payroll()
    {
        $payroll = Payroll::factory()->create();

        $resp = $this->payrollRepo->delete($payroll->id);

        $this->assertTrue($resp);
        $this->assertNull(Payroll::find($payroll->id), 'Payroll should not exist in DB');
    }
}
