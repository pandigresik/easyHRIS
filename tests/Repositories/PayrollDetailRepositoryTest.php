<?php namespace Tests\Repositories;

use App\Models\Hr\PayrollDetail;
use App\Repositories\Hr\PayrollDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class PayrollDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var PayrollDetailRepository
     */
    protected $payrollDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->payrollDetailRepo = \App::make(PayrollDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->make()->toArray();

        $createdPayrollDetail = $this->payrollDetailRepo->create($payrollDetail);

        $createdPayrollDetail = $createdPayrollDetail->toArray();
        $this->assertArrayHasKey('id', $createdPayrollDetail);
        $this->assertNotNull($createdPayrollDetail['id'], 'Created PayrollDetail must have id specified');
        $this->assertNotNull(PayrollDetail::find($createdPayrollDetail['id']), 'PayrollDetail with given id must be in DB');
        $this->assertModelData($payrollDetail, $createdPayrollDetail);
    }

    /**
     * @test read
     */
    public function test_read_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->create();

        $dbPayrollDetail = $this->payrollDetailRepo->find($payrollDetail->id);

        $dbPayrollDetail = $dbPayrollDetail->toArray();
        $this->assertModelData($payrollDetail->toArray(), $dbPayrollDetail);
    }

    /**
     * @test update
     */
    public function test_update_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->create();
        $fakePayrollDetail = PayrollDetail::factory()->make()->toArray();

        $updatedPayrollDetail = $this->payrollDetailRepo->update($fakePayrollDetail, $payrollDetail->id);

        $this->assertModelData($fakePayrollDetail, $updatedPayrollDetail->toArray());
        $dbPayrollDetail = $this->payrollDetailRepo->find($payrollDetail->id);
        $this->assertModelData($fakePayrollDetail, $dbPayrollDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_payroll_detail()
    {
        $payrollDetail = PayrollDetail::factory()->create();

        $resp = $this->payrollDetailRepo->delete($payrollDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(PayrollDetail::find($payrollDetail->id), 'PayrollDetail should not exist in DB');
    }
}
