<?php namespace Tests\Repositories;

use App\Models\Utility\FailedJob;
use App\Repositories\Utility\FailedJobRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class FailedJobRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var FailedJobRepository
     */
    protected $failedJobRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->failedJobRepo = \App::make(FailedJobRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_failed_job()
    {
        $failedJob = FailedJob::factory()->make()->toArray();

        $createdFailedJob = $this->failedJobRepo->create($failedJob);

        $createdFailedJob = $createdFailedJob->toArray();
        $this->assertArrayHasKey('id', $createdFailedJob);
        $this->assertNotNull($createdFailedJob['id'], 'Created FailedJob must have id specified');
        $this->assertNotNull(FailedJob::find($createdFailedJob['id']), 'FailedJob with given id must be in DB');
        $this->assertModelData($failedJob, $createdFailedJob);
    }

    /**
     * @test read
     */
    public function test_read_failed_job()
    {
        $failedJob = FailedJob::factory()->create();

        $dbFailedJob = $this->failedJobRepo->find($failedJob->id);

        $dbFailedJob = $dbFailedJob->toArray();
        $this->assertModelData($failedJob->toArray(), $dbFailedJob);
    }

    /**
     * @test update
     */
    public function test_update_failed_job()
    {
        $failedJob = FailedJob::factory()->create();
        $fakeFailedJob = FailedJob::factory()->make()->toArray();

        $updatedFailedJob = $this->failedJobRepo->update($fakeFailedJob, $failedJob->id);

        $this->assertModelData($fakeFailedJob, $updatedFailedJob->toArray());
        $dbFailedJob = $this->failedJobRepo->find($failedJob->id);
        $this->assertModelData($fakeFailedJob, $dbFailedJob->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_failed_job()
    {
        $failedJob = FailedJob::factory()->create();

        $resp = $this->failedJobRepo->delete($failedJob->id);

        $this->assertTrue($resp);
        $this->assertNull(FailedJob::find($failedJob->id), 'FailedJob should not exist in DB');
    }
}
