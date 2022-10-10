<?php namespace Tests\Repositories;

use App\Models\Hr\SalaryBenefitHistory;
use App\Repositories\Hr\SalaryBenefitHistoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalaryBenefitHistoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryBenefitHistoryRepository
     */
    protected $salaryBenefitHistoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salaryBenefitHistoryRepo = \App::make(SalaryBenefitHistoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->make()->toArray();

        $createdSalaryBenefitHistory = $this->salaryBenefitHistoryRepo->create($salaryBenefitHistory);

        $createdSalaryBenefitHistory = $createdSalaryBenefitHistory->toArray();
        $this->assertArrayHasKey('id', $createdSalaryBenefitHistory);
        $this->assertNotNull($createdSalaryBenefitHistory['id'], 'Created SalaryBenefitHistory must have id specified');
        $this->assertNotNull(SalaryBenefitHistory::find($createdSalaryBenefitHistory['id']), 'SalaryBenefitHistory with given id must be in DB');
        $this->assertModelData($salaryBenefitHistory, $createdSalaryBenefitHistory);
    }

    /**
     * @test read
     */
    public function test_read_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->create();

        $dbSalaryBenefitHistory = $this->salaryBenefitHistoryRepo->find($salaryBenefitHistory->id);

        $dbSalaryBenefitHistory = $dbSalaryBenefitHistory->toArray();
        $this->assertModelData($salaryBenefitHistory->toArray(), $dbSalaryBenefitHistory);
    }

    /**
     * @test update
     */
    public function test_update_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->create();
        $fakeSalaryBenefitHistory = SalaryBenefitHistory::factory()->make()->toArray();

        $updatedSalaryBenefitHistory = $this->salaryBenefitHistoryRepo->update($fakeSalaryBenefitHistory, $salaryBenefitHistory->id);

        $this->assertModelData($fakeSalaryBenefitHistory, $updatedSalaryBenefitHistory->toArray());
        $dbSalaryBenefitHistory = $this->salaryBenefitHistoryRepo->find($salaryBenefitHistory->id);
        $this->assertModelData($fakeSalaryBenefitHistory, $dbSalaryBenefitHistory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_salary_benefit_history()
    {
        $salaryBenefitHistory = SalaryBenefitHistory::factory()->create();

        $resp = $this->salaryBenefitHistoryRepo->delete($salaryBenefitHistory->id);

        $this->assertTrue($resp);
        $this->assertNull(SalaryBenefitHistory::find($salaryBenefitHistory->id), 'SalaryBenefitHistory should not exist in DB');
    }
}
