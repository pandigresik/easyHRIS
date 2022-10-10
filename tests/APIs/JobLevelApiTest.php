<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\JobLevel;

class JobLevelApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job_level()
    {
        $jobLevel = JobLevel::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/job_levels', $jobLevel
        );

        $this->assertApiResponse($jobLevel);
    }

    /**
     * @test
     */
    public function test_read_job_level()
    {
        $jobLevel = JobLevel::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/job_levels/'.$jobLevel->id
        );

        $this->assertApiResponse($jobLevel->toArray());
    }

    /**
     * @test
     */
    public function test_update_job_level()
    {
        $jobLevel = JobLevel::factory()->create();
        $editedJobLevel = JobLevel::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/job_levels/'.$jobLevel->id,
            $editedJobLevel
        );

        $this->assertApiResponse($editedJobLevel);
    }

    /**
     * @test
     */
    public function test_delete_job_level()
    {
        $jobLevel = JobLevel::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/job_levels/'.$jobLevel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/job_levels/'.$jobLevel->id
        );

        $this->response->assertStatus(404);
    }
}
