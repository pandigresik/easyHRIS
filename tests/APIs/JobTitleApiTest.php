<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\JobTitle;

class JobTitleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job_title()
    {
        $jobTitle = JobTitle::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/job_titles', $jobTitle
        );

        $this->assertApiResponse($jobTitle);
    }

    /**
     * @test
     */
    public function test_read_job_title()
    {
        $jobTitle = JobTitle::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/job_titles/'.$jobTitle->id
        );

        $this->assertApiResponse($jobTitle->toArray());
    }

    /**
     * @test
     */
    public function test_update_job_title()
    {
        $jobTitle = JobTitle::factory()->create();
        $editedJobTitle = JobTitle::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/job_titles/'.$jobTitle->id,
            $editedJobTitle
        );

        $this->assertApiResponse($editedJobTitle);
    }

    /**
     * @test
     */
    public function test_delete_job_title()
    {
        $jobTitle = JobTitle::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/job_titles/'.$jobTitle->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/job_titles/'.$jobTitle->id
        );

        $this->response->assertStatus(404);
    }
}
