<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\ShiftmentGroupDetail;

class ShiftmentGroupDetailApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/shiftment_group_details', $shiftmentGroupDetail
        );

        $this->assertApiResponse($shiftmentGroupDetail);
    }

    /**
     * @test
     */
    public function test_read_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/shiftment_group_details/'.$shiftmentGroupDetail->id
        );

        $this->assertApiResponse($shiftmentGroupDetail->toArray());
    }

    /**
     * @test
     */
    public function test_update_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->create();
        $editedShiftmentGroupDetail = ShiftmentGroupDetail::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/shiftment_group_details/'.$shiftmentGroupDetail->id,
            $editedShiftmentGroupDetail
        );

        $this->assertApiResponse($editedShiftmentGroupDetail);
    }

    /**
     * @test
     */
    public function test_delete_shiftment_group_detail()
    {
        $shiftmentGroupDetail = ShiftmentGroupDetail::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/shiftment_group_details/'.$shiftmentGroupDetail->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/shiftment_group_details/'.$shiftmentGroupDetail->id
        );

        $this->response->assertStatus(404);
    }
}
