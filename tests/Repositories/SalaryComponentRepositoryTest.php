<?php namespace Tests\Repositories;

use App\Models\Hr\SalaryComponent;
use App\Repositories\Hr\SalaryComponentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalaryComponentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryComponentRepository
     */
    protected $salaryComponentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salaryComponentRepo = \App::make(SalaryComponentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->make()->toArray();

        $createdSalaryComponent = $this->salaryComponentRepo->create($salaryComponent);

        $createdSalaryComponent = $createdSalaryComponent->toArray();
        $this->assertArrayHasKey('id', $createdSalaryComponent);
        $this->assertNotNull($createdSalaryComponent['id'], 'Created SalaryComponent must have id specified');
        $this->assertNotNull(SalaryComponent::find($createdSalaryComponent['id']), 'SalaryComponent with given id must be in DB');
        $this->assertModelData($salaryComponent, $createdSalaryComponent);
    }

    /**
     * @test read
     */
    public function test_read_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->create();

        $dbSalaryComponent = $this->salaryComponentRepo->find($salaryComponent->id);

        $dbSalaryComponent = $dbSalaryComponent->toArray();
        $this->assertModelData($salaryComponent->toArray(), $dbSalaryComponent);
    }

    /**
     * @test update
     */
    public function test_update_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->create();
        $fakeSalaryComponent = SalaryComponent::factory()->make()->toArray();

        $updatedSalaryComponent = $this->salaryComponentRepo->update($fakeSalaryComponent, $salaryComponent->id);

        $this->assertModelData($fakeSalaryComponent, $updatedSalaryComponent->toArray());
        $dbSalaryComponent = $this->salaryComponentRepo->find($salaryComponent->id);
        $this->assertModelData($fakeSalaryComponent, $dbSalaryComponent->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_salary_component()
    {
        $salaryComponent = SalaryComponent::factory()->create();

        $resp = $this->salaryComponentRepo->delete($salaryComponent->id);

        $this->assertTrue($resp);
        $this->assertNull(SalaryComponent::find($salaryComponent->id), 'SalaryComponent should not exist in DB');
    }
}
