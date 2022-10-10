<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\ShiftmentGroup;

class ShiftmentGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/shiftment_groups', $shiftmentGroup
        );

        $this->assertApiResponse($shiftmentGroup);
    }

    /**
     * @test
     */
    public function test_read_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/shiftment_groups/'.$shiftmentGroup->id
        );

        $this->assertApiResponse($shiftmentGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->create();
        $editedShiftmentGroup = ShiftmentGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/shiftment_groups/'.$shiftmentGroup->id,
            $editedShiftmentGroup
        );

        $this->assertApiResponse($editedShiftmentGroup);
    }

    /**
     * @test
     */
    public function test_delete_shiftment_group()
    {
        $shiftmentGroup = ShiftmentGroup::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/shiftment_groups/'.$shiftmentGroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/shiftment_groups/'.$shiftmentGroup->id
        );

        $this->response->assertStatus(404);
    }
}
