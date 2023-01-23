<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Utility\Job;

class JobApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job()
    {
        $job = Job::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/utility/jobs', $job
        );

        $this->assertApiResponse($job);
    }

    /**
     * @test
     */
    public function test_read_job()
    {
        $job = Job::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/utility/jobs/'.$job->id
        );

        $this->assertApiResponse($job->toArray());
    }

    /**
     * @test
     */
    public function test_update_job()
    {
        $job = Job::factory()->create();
        $editedJob = Job::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/utility/jobs/'.$job->id,
            $editedJob
        );

        $this->assertApiResponse($editedJob);
    }

    /**
     * @test
     */
    public function test_delete_job()
    {
        $job = Job::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/utility/jobs/'.$job->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/utility/jobs/'.$job->id
        );

        $this->response->assertStatus(404);
    }
}
