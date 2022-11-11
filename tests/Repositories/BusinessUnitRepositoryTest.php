<?php namespace Tests\Repositories;

use App\Models\Base\BusinessUnit;
use App\Repositories\Base\BusinessUnitRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class BusinessUnitRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var BusinessUnitRepository
     */
    protected $businessUnitRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->businessUnitRepo = \App::make(BusinessUnitRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->make()->toArray();

        $createdBusinessUnit = $this->businessUnitRepo->create($businessUnit);

        $createdBusinessUnit = $createdBusinessUnit->toArray();
        $this->assertArrayHasKey('id', $createdBusinessUnit);
        $this->assertNotNull($createdBusinessUnit['id'], 'Created BusinessUnit must have id specified');
        $this->assertNotNull(BusinessUnit::find($createdBusinessUnit['id']), 'BusinessUnit with given id must be in DB');
        $this->assertModelData($businessUnit, $createdBusinessUnit);
    }

    /**
     * @test read
     */
    public function test_read_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $dbBusinessUnit = $this->businessUnitRepo->find($businessUnit->id);

        $dbBusinessUnit = $dbBusinessUnit->toArray();
        $this->assertModelData($businessUnit->toArray(), $dbBusinessUnit);
    }

    /**
     * @test update
     */
    public function test_update_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();
        $fakeBusinessUnit = BusinessUnit::factory()->make()->toArray();

        $updatedBusinessUnit = $this->businessUnitRepo->update($fakeBusinessUnit, $businessUnit->id);

        $this->assertModelData($fakeBusinessUnit, $updatedBusinessUnit->toArray());
        $dbBusinessUnit = $this->businessUnitRepo->find($businessUnit->id);
        $this->assertModelData($fakeBusinessUnit, $dbBusinessUnit->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_business_unit()
    {
        $businessUnit = BusinessUnit::factory()->create();

        $resp = $this->businessUnitRepo->delete($businessUnit->id);

        $this->assertTrue($resp);
        $this->assertNull(BusinessUnit::find($businessUnit->id), 'BusinessUnit should not exist in DB');
    }
}
