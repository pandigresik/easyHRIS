<?php namespace Tests\Repositories;

use App\Models\Hr\Workshift;
use App\Repositories\Hr\WorkshiftRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class WorkshiftRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var WorkshiftRepository
     */
    protected $workshiftRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->workshiftRepo = \App::make(WorkshiftRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_workshift()
    {
        $workshift = Workshift::factory()->make()->toArray();

        $createdWorkshift = $this->workshiftRepo->create($workshift);

        $createdWorkshift = $createdWorkshift->toArray();
        $this->assertArrayHasKey('id', $createdWorkshift);
        $this->assertNotNull($createdWorkshift['id'], 'Created Workshift must have id specified');
        $this->assertNotNull(Workshift::find($createdWorkshift['id']), 'Workshift with given id must be in DB');
        $this->assertModelData($workshift, $createdWorkshift);
    }

    /**
     * @test read
     */
    public function test_read_workshift()
    {
        $workshift = Workshift::factory()->create();

        $dbWorkshift = $this->workshiftRepo->find($workshift->id);

        $dbWorkshift = $dbWorkshift->toArray();
        $this->assertModelData($workshift->toArray(), $dbWorkshift);
    }

    /**
     * @test update
     */
    public function test_update_workshift()
    {
        $workshift = Workshift::factory()->create();
        $fakeWorkshift = Workshift::factory()->make()->toArray();

        $updatedWorkshift = $this->workshiftRepo->update($fakeWorkshift, $workshift->id);

        $this->assertModelData($fakeWorkshift, $updatedWorkshift->toArray());
        $dbWorkshift = $this->workshiftRepo->find($workshift->id);
        $this->assertModelData($fakeWorkshift, $dbWorkshift->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_workshift()
    {
        $workshift = Workshift::factory()->create();

        $resp = $this->workshiftRepo->delete($workshift->id);

        $this->assertTrue($resp);
        $this->assertNull(Workshift::find($workshift->id), 'Workshift should not exist in DB');
    }
}
