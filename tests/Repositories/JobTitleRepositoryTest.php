<?php namespace Tests\Repositories;

use App\Models\Hr\JobTitle;
use App\Repositories\Hr\JobTitleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JobTitleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobTitleRepository
     */
    protected $jobTitleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jobTitleRepo = \App::make(JobTitleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_job_title()
    {
        $jobTitle = JobTitle::factory()->make()->toArray();

        $createdJobTitle = $this->jobTitleRepo->create($jobTitle);

        $createdJobTitle = $createdJobTitle->toArray();
        $this->assertArrayHasKey('id', $createdJobTitle);
        $this->assertNotNull($createdJobTitle['id'], 'Created JobTitle must have id specified');
        $this->assertNotNull(JobTitle::find($createdJobTitle['id']), 'JobTitle with given id must be in DB');
        $this->assertModelData($jobTitle, $createdJobTitle);
    }

    /**
     * @test read
     */
    public function test_read_job_title()
    {
        $jobTitle = JobTitle::factory()->create();

        $dbJobTitle = $this->jobTitleRepo->find($jobTitle->id);

        $dbJobTitle = $dbJobTitle->toArray();
        $this->assertModelData($jobTitle->toArray(), $dbJobTitle);
    }

    /**
     * @test update
     */
    public function test_update_job_title()
    {
        $jobTitle = JobTitle::factory()->create();
        $fakeJobTitle = JobTitle::factory()->make()->toArray();

        $updatedJobTitle = $this->jobTitleRepo->update($fakeJobTitle, $jobTitle->id);

        $this->assertModelData($fakeJobTitle, $updatedJobTitle->toArray());
        $dbJobTitle = $this->jobTitleRepo->find($jobTitle->id);
        $this->assertModelData($fakeJobTitle, $dbJobTitle->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_job_title()
    {
        $jobTitle = JobTitle::factory()->create();

        $resp = $this->jobTitleRepo->delete($jobTitle->id);

        $this->assertTrue($resp);
        $this->assertNull(JobTitle::find($jobTitle->id), 'JobTitle should not exist in DB');
    }
}
