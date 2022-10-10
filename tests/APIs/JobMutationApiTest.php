<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\JobMutation;

class JobMutationApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job_mutation()
    {
        $jobMutation = JobMutation::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/job_mutations', $jobMutation
        );

        $this->assertApiResponse($jobMutation);
    }

    /**
     * @test
     */
    public function test_read_job_mutation()
    {
        $jobMutation = JobMutation::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/job_mutations/'.$jobMutation->id
        );

        $this->assertApiResponse($jobMutation->toArray());
    }

    /**
     * @test
     */
    public function test_update_job_mutation()
    {
        $jobMutation = JobMutation::factory()->create();
        $editedJobMutation = JobMutation::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/job_mutations/'.$jobMutation->id,
            $editedJobMutation
        );

        $this->assertApiResponse($editedJobMutation);
    }

    /**
     * @test
     */
    public function test_delete_job_mutation()
    {
        $jobMutation = JobMutation::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/job_mutations/'.$jobMutation->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/job_mutations/'.$jobMutation->id
        );

        $this->response->assertStatus(404);
    }
}
