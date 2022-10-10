<?php namespace Tests\Repositories;

use App\Models\Hr\SalaryAllowance;
use App\Repositories\Hr\SalaryAllowanceRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalaryAllowanceRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryAllowanceRepository
     */
    protected $salaryAllowanceRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salaryAllowanceRepo = \App::make(SalaryAllowanceRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->make()->toArray();

        $createdSalaryAllowance = $this->salaryAllowanceRepo->create($salaryAllowance);

        $createdSalaryAllowance = $createdSalaryAllowance->toArray();
        $this->assertArrayHasKey('id', $createdSalaryAllowance);
        $this->assertNotNull($createdSalaryAllowance['id'], 'Created SalaryAllowance must have id specified');
        $this->assertNotNull(SalaryAllowance::find($createdSalaryAllowance['id']), 'SalaryAllowance with given id must be in DB');
        $this->assertModelData($salaryAllowance, $createdSalaryAllowance);
    }

    /**
     * @test read
     */
    public function test_read_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->create();

        $dbSalaryAllowance = $this->salaryAllowanceRepo->find($salaryAllowance->id);

        $dbSalaryAllowance = $dbSalaryAllowance->toArray();
        $this->assertModelData($salaryAllowance->toArray(), $dbSalaryAllowance);
    }

    /**
     * @test update
     */
    public function test_update_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->create();
        $fakeSalaryAllowance = SalaryAllowance::factory()->make()->toArray();

        $updatedSalaryAllowance = $this->salaryAllowanceRepo->update($fakeSalaryAllowance, $salaryAllowance->id);

        $this->assertModelData($fakeSalaryAllowance, $updatedSalaryAllowance->toArray());
        $dbSalaryAllowance = $this->salaryAllowanceRepo->find($salaryAllowance->id);
        $this->assertModelData($fakeSalaryAllowance, $dbSalaryAllowance->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_salary_allowance()
    {
        $salaryAllowance = SalaryAllowance::factory()->create();

        $resp = $this->salaryAllowanceRepo->delete($salaryAllowance->id);

        $this->assertTrue($resp);
        $this->assertNull(SalaryAllowance::find($salaryAllowance->id), 'SalaryAllowance should not exist in DB');
    }
}
