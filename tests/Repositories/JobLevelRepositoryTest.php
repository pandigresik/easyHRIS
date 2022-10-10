<?php namespace Tests\Repositories;

use App\Models\Hr\JobLevel;
use App\Repositories\Hr\JobLevelRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class JobLevelRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var JobLevelRepository
     */
    protected $jobLevelRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->jobLevelRepo = \App::make(JobLevelRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_job_level()
    {
        $jobLevel = JobLevel::factory()->make()->toArray();

        $createdJobLevel = $this->jobLevelRepo->create($jobLevel);

        $createdJobLevel = $createdJobLevel->toArray();
        $this->assertArrayHasKey('id', $createdJobLevel);
        $this->assertNotNull($createdJobLevel['id'], 'Created JobLevel must have id specified');
        $this->assertNotNull(JobLevel::find($createdJobLevel['id']), 'JobLevel with given id must be in DB');
        $this->assertModelData($jobLevel, $createdJobLevel);
    }

    /**
     * @test read
     */
    public function test_read_job_level()
    {
        $jobLevel = JobLevel::factory()->create();

        $dbJobLevel = $this->jobLevelRepo->find($jobLevel->id);

        $dbJobLevel = $dbJobLevel->toArray();
        $this->assertModelData($jobLevel->toArray(), $dbJobLevel);
    }

    /**
     * @test update
     */
    public function test_update_job_level()
    {
        $jobLevel = JobLevel::factory()->create();
        $fakeJobLevel = JobLevel::factory()->make()->toArray();

        $updatedJobLevel = $this->jobLevelRepo->update($fakeJobLevel, $jobLevel->id);

        $this->assertModelData($fakeJobLevel, $updatedJobLevel->toArray());
        $dbJobLevel = $this->jobLevelRepo->find($jobLevel->id);
        $this->assertModelData($fakeJobLevel, $dbJobLevel->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_job_level()
    {
        $jobLevel = JobLevel::factory()->create();

        $resp = $this->jobLevelRepo->delete($jobLevel->id);

        $this->assertTrue($resp);
        $this->assertNull(JobLevel::find($jobLevel->id), 'JobLevel should not exist in DB');
    }
}
