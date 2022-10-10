<?php namespace Tests\Repositories;

use App\Models\Hr\SalaryGroup;
use App\Repositories\Hr\SalaryGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalaryGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryGroupRepository
     */
    protected $salaryGroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salaryGroupRepo = \App::make(SalaryGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->make()->toArray();

        $createdSalaryGroup = $this->salaryGroupRepo->create($salaryGroup);

        $createdSalaryGroup = $createdSalaryGroup->toArray();
        $this->assertArrayHasKey('id', $createdSalaryGroup);
        $this->assertNotNull($createdSalaryGroup['id'], 'Created SalaryGroup must have id specified');
        $this->assertNotNull(SalaryGroup::find($createdSalaryGroup['id']), 'SalaryGroup with given id must be in DB');
        $this->assertModelData($salaryGroup, $createdSalaryGroup);
    }

    /**
     * @test read
     */
    public function test_read_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->create();

        $dbSalaryGroup = $this->salaryGroupRepo->find($salaryGroup->id);

        $dbSalaryGroup = $dbSalaryGroup->toArray();
        $this->assertModelData($salaryGroup->toArray(), $dbSalaryGroup);
    }

    /**
     * @test update
     */
    public function test_update_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->create();
        $fakeSalaryGroup = SalaryGroup::factory()->make()->toArray();

        $updatedSalaryGroup = $this->salaryGroupRepo->update($fakeSalaryGroup, $salaryGroup->id);

        $this->assertModelData($fakeSalaryGroup, $updatedSalaryGroup->toArray());
        $dbSalaryGroup = $this->salaryGroupRepo->find($salaryGroup->id);
        $this->assertModelData($fakeSalaryGroup, $dbSalaryGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_salary_group()
    {
        $salaryGroup = SalaryGroup::factory()->create();

        $resp = $this->salaryGroupRepo->delete($salaryGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(SalaryGroup::find($salaryGroup->id), 'SalaryGroup should not exist in DB');
    }
}
