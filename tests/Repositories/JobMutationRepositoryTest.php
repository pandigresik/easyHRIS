<?php namespace Tests\Repositories;

use App\Models\Hr\JobMutation;
use App\Repositories\Hr\JobMutationRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JobMutationRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobMutationRepository
     */
    protected $jobMutationRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jobMutationRepo = \App::make(JobMutationRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_job_mutation()
    {
        $jobMutation = JobMutation::factory()->make()->toArray();

        $createdJobMutation = $this->jobMutationRepo->create($jobMutation);

        $createdJobMutation = $createdJobMutation->toArray();
        $this->assertArrayHasKey('id', $createdJobMutation);
        $this->assertNotNull($createdJobMutation['id'], 'Created JobMutation must have id specified');
        $this->assertNotNull(JobMutation::find($createdJobMutation['id']), 'JobMutation with given id must be in DB');
        $this->assertModelData($jobMutation, $createdJobMutation);
    }

    /**
     * @test read
     */
    public function test_read_job_mutation()
    {
        $jobMutation = JobMutation::factory()->create();

        $dbJobMutation = $this->jobMutationRepo->find($jobMutation->id);

        $dbJobMutation = $dbJobMutation->toArray();
        $this->assertModelData($jobMutation->toArray(), $dbJobMutation);
    }

    /**
     * @test update
     */
    public function test_update_job_mutation()
    {
        $jobMutation = JobMutation::factory()->create();
        $fakeJobMutation = JobMutation::factory()->make()->toArray();

        $updatedJobMutation = $this->jobMutationRepo->update($fakeJobMutation, $jobMutation->id);

        $this->assertModelData($fakeJobMutation, $updatedJobMutation->toArray());
        $dbJobMutation = $this->jobMutationRepo->find($jobMutation->id);
        $this->assertModelData($fakeJobMutation, $dbJobMutation->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_job_mutation()
    {
        $jobMutation = JobMutation::factory()->create();

        $resp = $this->jobMutationRepo->delete($jobMutation->id);

        $this->assertTrue($resp);
        $this->assertNull(JobMutation::find($jobMutation->id), 'JobMutation should not exist in DB');
    }
}
