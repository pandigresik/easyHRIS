<?php namespace Tests\Repositories;

use App\Models\Hr\SalaryBenefit;
use App\Repositories\Hr\SalaryBenefitRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalaryBenefitRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryBenefitRepository
     */
    protected $salaryBenefitRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salaryBenefitRepo = \App::make(SalaryBenefitRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->make()->toArray();

        $createdSalaryBenefit = $this->salaryBenefitRepo->create($salaryBenefit);

        $createdSalaryBenefit = $createdSalaryBenefit->toArray();
        $this->assertArrayHasKey('id', $createdSalaryBenefit);
        $this->assertNotNull($createdSalaryBenefit['id'], 'Created SalaryBenefit must have id specified');
        $this->assertNotNull(SalaryBenefit::find($createdSalaryBenefit['id']), 'SalaryBenefit with given id must be in DB');
        $this->assertModelData($salaryBenefit, $createdSalaryBenefit);
    }

    /**
     * @test read
     */
    public function test_read_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->create();

        $dbSalaryBenefit = $this->salaryBenefitRepo->find($salaryBenefit->id);

        $dbSalaryBenefit = $dbSalaryBenefit->toArray();
        $this->assertModelData($salaryBenefit->toArray(), $dbSalaryBenefit);
    }

    /**
     * @test update
     */
    public function test_update_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->create();
        $fakeSalaryBenefit = SalaryBenefit::factory()->make()->toArray();

        $updatedSalaryBenefit = $this->salaryBenefitRepo->update($fakeSalaryBenefit, $salaryBenefit->id);

        $this->assertModelData($fakeSalaryBenefit, $updatedSalaryBenefit->toArray());
        $dbSalaryBenefit = $this->salaryBenefitRepo->find($salaryBenefit->id);
        $this->assertModelData($fakeSalaryBenefit, $dbSalaryBenefit->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_salary_benefit()
    {
        $salaryBenefit = SalaryBenefit::factory()->create();

        $resp = $this->salaryBenefitRepo->delete($salaryBenefit->id);

        $this->assertTrue($resp);
        $this->assertNull(SalaryBenefit::find($salaryBenefit->id), 'SalaryBenefit should not exist in DB');
    }
}
