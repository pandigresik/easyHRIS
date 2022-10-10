<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\JobPlacement;

class JobPlacementApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/job_placements', $jobPlacement
        );

        $this->assertApiResponse($jobPlacement);
    }

    /**
     * @test
     */
    public function test_read_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/job_placements/'.$jobPlacement->id
        );

        $this->assertApiResponse($jobPlacement->toArray());
    }

    /**
     * @test
     */
    public function test_update_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->create();
        $editedJobPlacement = JobPlacement::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/job_placements/'.$jobPlacement->id,
            $editedJobPlacement
        );

        $this->assertApiResponse($editedJobPlacement);
    }

    /**
     * @test
     */
    public function test_delete_job_placement()
    {
        $jobPlacement = JobPlacement::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/job_placements/'.$jobPlacement->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/job_placements/'.$jobPlacement->id
        );

        $this->response->assertStatus(404);
    }
}
