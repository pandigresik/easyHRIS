<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\CareerHistory;

class CareerHistoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_career_history()
    {
        $careerHistory = CareerHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/career_histories', $careerHistory
        );

        $this->assertApiResponse($careerHistory);
    }

    /**
     * @test
     */
    public function test_read_career_history()
    {
        $careerHistory = CareerHistory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/career_histories/'.$careerHistory->id
        );

        $this->assertApiResponse($careerHistory->toArray());
    }

    /**
     * @test
     */
    public function test_update_career_history()
    {
        $careerHistory = CareerHistory::factory()->create();
        $editedCareerHistory = CareerHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/career_histories/'.$careerHistory->id,
            $editedCareerHistory
        );

        $this->assertApiResponse($editedCareerHistory);
    }

    /**
     * @test
     */
    public function test_delete_career_history()
    {
        $careerHistory = CareerHistory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/career_histories/'.$careerHistory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/career_histories/'.$careerHistory->id
        );

        $this->response->assertStatus(404);
    }
}
