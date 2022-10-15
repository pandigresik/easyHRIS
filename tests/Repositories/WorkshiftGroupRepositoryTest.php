<?php namespace Tests\Repositories;

use App\Models\Hr\WorkshiftGroup;
use App\Repositories\Hr\WorkshiftGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class WorkshiftGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkshiftGroupRepository
     */
    protected $workshiftGroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->workshiftGroupRepo = \App::make(WorkshiftGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->make()->toArray();

        $createdWorkshiftGroup = $this->workshiftGroupRepo->create($workshiftGroup);

        $createdWorkshiftGroup = $createdWorkshiftGroup->toArray();
        $this->assertArrayHasKey('id', $createdWorkshiftGroup);
        $this->assertNotNull($createdWorkshiftGroup['id'], 'Created WorkshiftGroup must have id specified');
        $this->assertNotNull(WorkshiftGroup::find($createdWorkshiftGroup['id']), 'WorkshiftGroup with given id must be in DB');
        $this->assertModelData($workshiftGroup, $createdWorkshiftGroup);
    }

    /**
     * @test read
     */
    public function test_read_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->create();

        $dbWorkshiftGroup = $this->workshiftGroupRepo->find($workshiftGroup->id);

        $dbWorkshiftGroup = $dbWorkshiftGroup->toArray();
        $this->assertModelData($workshiftGroup->toArray(), $dbWorkshiftGroup);
    }

    /**
     * @test update
     */
    public function test_update_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->create();
        $fakeWorkshiftGroup = WorkshiftGroup::factory()->make()->toArray();

        $updatedWorkshiftGroup = $this->workshiftGroupRepo->update($fakeWorkshiftGroup, $workshiftGroup->id);

        $this->assertModelData($fakeWorkshiftGroup, $updatedWorkshiftGroup->toArray());
        $dbWorkshiftGroup = $this->workshiftGroupRepo->find($workshiftGroup->id);
        $this->assertModelData($fakeWorkshiftGroup, $dbWorkshiftGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->create();

        $resp = $this->workshiftGroupRepo->delete($workshiftGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(WorkshiftGroup::find($workshiftGroup->id), 'WorkshiftGroup should not exist in DB');
    }
}
