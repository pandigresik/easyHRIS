<?php namespace Tests\Repositories;

use App\Models\Hr\GroupingPayrollEntity;
use App\Repositories\Hr\GroupingPayrollEntityRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class GroupingPayrollEntityRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var GroupingPayrollEntityRepository
     */
    protected $groupingPayrollEntityRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->groupingPayrollEntityRepo = \App::make(GroupingPayrollEntityRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->make()->toArray();

        $createdGroupingPayrollEntity = $this->groupingPayrollEntityRepo->create($groupingPayrollEntity);

        $createdGroupingPayrollEntity = $createdGroupingPayrollEntity->toArray();
        $this->assertArrayHasKey('id', $createdGroupingPayrollEntity);
        $this->assertNotNull($createdGroupingPayrollEntity['id'], 'Created GroupingPayrollEntity must have id specified');
        $this->assertNotNull(GroupingPayrollEntity::find($createdGroupingPayrollEntity['id']), 'GroupingPayrollEntity with given id must be in DB');
        $this->assertModelData($groupingPayrollEntity, $createdGroupingPayrollEntity);
    }

    /**
     * @test read
     */
    public function test_read_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->create();

        $dbGroupingPayrollEntity = $this->groupingPayrollEntityRepo->find($groupingPayrollEntity->id);

        $dbGroupingPayrollEntity = $dbGroupingPayrollEntity->toArray();
        $this->assertModelData($groupingPayrollEntity->toArray(), $dbGroupingPayrollEntity);
    }

    /**
     * @test update
     */
    public function test_update_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->create();
        $fakeGroupingPayrollEntity = GroupingPayrollEntity::factory()->make()->toArray();

        $updatedGroupingPayrollEntity = $this->groupingPayrollEntityRepo->update($fakeGroupingPayrollEntity, $groupingPayrollEntity->id);

        $this->assertModelData($fakeGroupingPayrollEntity, $updatedGroupingPayrollEntity->toArray());
        $dbGroupingPayrollEntity = $this->groupingPayrollEntityRepo->find($groupingPayrollEntity->id);
        $this->assertModelData($fakeGroupingPayrollEntity, $dbGroupingPayrollEntity->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->create();

        $resp = $this->groupingPayrollEntityRepo->delete($groupingPayrollEntity->id);

        $this->assertTrue($resp);
        $this->assertNull(GroupingPayrollEntity::find($groupingPayrollEntity->id), 'GroupingPayrollEntity should not exist in DB');
    }
}
