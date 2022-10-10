<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\AbsentReason;

class AbsentReasonApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_absent_reason()
    {
        $absentReason = AbsentReason::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/absent_reasons', $absentReason
        );

        $this->assertApiResponse($absentReason);
    }

    /**
     * @test
     */
    public function test_read_absent_reason()
    {
        $absentReason = AbsentReason::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/absent_reasons/'.$absentReason->id
        );

        $this->assertApiResponse($absentReason->toArray());
    }

    /**
     * @test
     */
    public function test_update_absent_reason()
    {
        $absentReason = AbsentReason::factory()->create();
        $editedAbsentReason = AbsentReason::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/absent_reasons/'.$absentReason->id,
            $editedAbsentReason
        );

        $this->assertApiResponse($editedAbsentReason);
    }

    /**
     * @test
     */
    public function test_delete_absent_reason()
    {
        $absentReason = AbsentReason::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/absent_reasons/'.$absentReason->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/absent_reasons/'.$absentReason->id
        );

        $this->response->assertStatus(404);
    }
}
