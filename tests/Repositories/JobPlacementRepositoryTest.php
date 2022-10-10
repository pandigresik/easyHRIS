<?php namespace Tests\Repositories;

use App\Models\Hr\JobPlacement;
use App\Repositories\Hr\JobPlacementRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JobPlacementRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobPlacementRepository
     */
    protected $jobPlacementRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jobPlacementRepo = \App::make(JobPlacementRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->make()->toArray();

        $createdJobPlacement = $this->jobPlacementRepo->create($jobPlacement);

        $createdJobPlacement = $createdJobPlacement->toArray();
        $this->assertArrayHasKey('id', $createdJobPlacement);
        $this->assertNotNull($createdJobPlacement['id'], 'Created JobPlacement must have id specified');
        $this->assertNotNull(JobPlacement::find($createdJobPlacement['id']), 'JobPlacement with given id must be in DB');
        $this->assertModelData($jobPlacement, $createdJobPlacement);
    }

    /**
     * @test read
     */
    public function test_read_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->create();

        $dbJobPlacement = $this->jobPlacementRepo->find($jobPlacement->id);

        $dbJobPlacement = $dbJobPlacement->toArray();
        $this->assertModelData($jobPlacement->toArray(), $dbJobPlacement);
    }

    /**
     * @test update
     */
    public function test_update_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->create();
        $fakeJobPlacement = JobPlacement::factory()->make()->toArray();

        $updatedJobPlacement = $this->jobPlacementRepo->update($fakeJobPlacement, $jobPlacement->id);

        $this->assertModelData($fakeJobPlacement, $updatedJobPlacement->toArray());
        $dbJobPlacement = $this->jobPlacementRepo->find($jobPlacement->id);
        $this->assertModelData($fakeJobPlacement, $dbJobPlacement->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->create();

        $resp = $this->jobPlacementRepo->delete($jobPlacement->id);

        $this->assertTrue($resp);
        $this->assertNull(JobPlacement::find($jobPlacement->id), 'JobPlacement should not exist in DB');
    }
}
