<?php namespace Tests\Repositories;

use App\Models\Utility\Job;
use App\Repositories\Utility\JobRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JobRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobRepository
     */
    protected $jobRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jobRepo = \App::make(JobRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_job()
    {
        $job = Job::factory()->make()->toArray();

        $createdJob = $this->jobRepo->create($job);

        $createdJob = $createdJob->toArray();
        $this->assertArrayHasKey('id', $createdJob);
        $this->assertNotNull($createdJob['id'], 'Created Job must have id specified');
        $this->assertNotNull(Job::find($createdJob['id']), 'Job with given id must be in DB');
        $this->assertModelData($job, $createdJob);
    }

    /**
     * @test read
     */
    public function test_read_job()
    {
        $job = Job::factory()->create();

        $dbJob = $this->jobRepo->find($job->id);

        $dbJob = $dbJob->toArray();
        $this->assertModelData($job->toArray(), $dbJob);
    }

    /**
     * @test update
     */
    public function test_update_job()
    {
        $job = Job::factory()->create();
        $fakeJob = Job::factory()->make()->toArray();

        $updatedJob = $this->jobRepo->update($fakeJob, $job->id);

        $this->assertModelData($fakeJob, $updatedJob->toArray());
        $dbJob = $this->jobRepo->find($job->id);
        $this->assertModelData($fakeJob, $dbJob->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_job()
    {
        $job = Job::factory()->create();

        $resp = $this->jobRepo->delete($job->id);

        $this->assertTrue($resp);
        $this->assertNull(Job::find($job->id), 'Job should not exist in DB');
    }
}
