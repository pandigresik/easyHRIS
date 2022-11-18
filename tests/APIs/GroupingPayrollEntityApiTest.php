<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\GroupingPayrollEntity;

class GroupingPayrollEntityApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/grouping_payroll_entities', $groupingPayrollEntity
        );

        $this->assertApiResponse($groupingPayrollEntity);
    }

    /**
     * @test
     */
    public function test_read_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/grouping_payroll_entities/'.$groupingPayrollEntity->id
        );

        $this->assertApiResponse($groupingPayrollEntity->toArray());
    }

    /**
     * @test
     */
    public function test_update_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->create();
        $editedGroupingPayrollEntity = GroupingPayrollEntity::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/grouping_payroll_entities/'.$groupingPayrollEntity->id,
            $editedGroupingPayrollEntity
        );

        $this->assertApiResponse($editedGroupingPayrollEntity);
    }

    /**
     * @test
     */
    public function test_delete_grouping_payroll_entity()
    {
        $groupingPayrollEntity = GroupingPayrollEntity::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/grouping_payroll_entities/'.$groupingPayrollEntity->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/grouping_payroll_entities/'.$groupingPayrollEntity->id
        );

        $this->response->assertStatus(404);
    }
}
