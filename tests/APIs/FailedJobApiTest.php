<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Utility\FailedJob;

class FailedJobApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_failed_job()
    {
        $failedJob = FailedJob::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/utility/failed_jobs', $failedJob
        );

        $this->assertApiResponse($failedJob);
    }

    /**
     * @test
     */
    public function test_read_failed_job()
    {
        $failedJob = FailedJob::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/utility/failed_jobs/'.$failedJob->id
        );

        $this->assertApiResponse($failedJob->toArray());
    }

    /**
     * @test
     */
    public function test_update_failed_job()
    {
        $failedJob = FailedJob::factory()->create();
        $editedFailedJob = FailedJob::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/utility/failed_jobs/'.$failedJob->id,
            $editedFailedJob
        );

        $this->assertApiResponse($editedFailedJob);
    }

    /**
     * @test
     */
    public function test_delete_failed_job()
    {
        $failedJob = FailedJob::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/utility/failed_jobs/'.$failedJob->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/utility/failed_jobs/'.$failedJob->id
        );

        $this->response->assertStatus(404);
    }
}
