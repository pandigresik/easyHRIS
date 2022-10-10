<?php namespace Tests\Repositories;

use App\Models\Hr\SalaryGroupDetail;
use App\Repositories\Hr\SalaryGroupDetailRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SalaryGroupDetailRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SalaryGroupDetailRepository
     */
    protected $salaryGroupDetailRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->salaryGroupDetailRepo = \App::make(SalaryGroupDetailRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->make()->toArray();

        $createdSalaryGroupDetail = $this->salaryGroupDetailRepo->create($salaryGroupDetail);

        $createdSalaryGroupDetail = $createdSalaryGroupDetail->toArray();
        $this->assertArrayHasKey('id', $createdSalaryGroupDetail);
        $this->assertNotNull($createdSalaryGroupDetail['id'], 'Created SalaryGroupDetail must have id specified');
        $this->assertNotNull(SalaryGroupDetail::find($createdSalaryGroupDetail['id']), 'SalaryGroupDetail with given id must be in DB');
        $this->assertModelData($salaryGroupDetail, $createdSalaryGroupDetail);
    }

    /**
     * @test read
     */
    public function test_read_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->create();

        $dbSalaryGroupDetail = $this->salaryGroupDetailRepo->find($salaryGroupDetail->id);

        $dbSalaryGroupDetail = $dbSalaryGroupDetail->toArray();
        $this->assertModelData($salaryGroupDetail->toArray(), $dbSalaryGroupDetail);
    }

    /**
     * @test update
     */
    public function test_update_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->create();
        $fakeSalaryGroupDetail = SalaryGroupDetail::factory()->make()->toArray();

        $updatedSalaryGroupDetail = $this->salaryGroupDetailRepo->update($fakeSalaryGroupDetail, $salaryGroupDetail->id);

        $this->assertModelData($fakeSalaryGroupDetail, $updatedSalaryGroupDetail->toArray());
        $dbSalaryGroupDetail = $this->salaryGroupDetailRepo->find($salaryGroupDetail->id);
        $this->assertModelData($fakeSalaryGroupDetail, $dbSalaryGroupDetail->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_salary_group_detail()
    {
        $salaryGroupDetail = SalaryGroupDetail::factory()->create();

        $resp = $this->salaryGroupDetailRepo->delete($salaryGroupDetail->id);

        $this->assertTrue($resp);
        $this->assertNull(SalaryGroupDetail::find($salaryGroupDetail->id), 'SalaryGroupDetail should not exist in DB');
    }
}
