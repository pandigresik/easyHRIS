<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\WorkshiftGroup;

class WorkshiftGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/workshift_groups', $workshiftGroup
        );

        $this->assertApiResponse($workshiftGroup);
    }

    /**
     * @test
     */
    public function test_read_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/workshift_groups/'.$workshiftGroup->id
        );

        $this->assertApiResponse($workshiftGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->create();
        $editedWorkshiftGroup = WorkshiftGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/workshift_groups/'.$workshiftGroup->id,
            $editedWorkshiftGroup
        );

        $this->assertApiResponse($editedWorkshiftGroup);
    }

    /**
     * @test
     */
    public function test_delete_workshift_group()
    {
        $workshiftGroup = WorkshiftGroup::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/workshift_groups/'.$workshiftGroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/workshift_groups/'.$workshiftGroup->id
        );

        $this->response->assertStatus(404);
    }
}
