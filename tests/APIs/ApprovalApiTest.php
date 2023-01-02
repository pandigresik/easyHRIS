<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Base\Approval;

class ApprovalApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_approval()
    {
        $approval = Approval::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/base/approvals', $approval
        );

        $this->assertApiResponse($approval);
    }

    /**
     * @test
     */
    public function test_read_approval()
    {
        $approval = Approval::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/base/approvals/'.$approval->id
        );

        $this->assertApiResponse($approval->toArray());
    }

    /**
     * @test
     */
    public function test_update_approval()
    {
        $approval = Approval::factory()->create();
        $editedApproval = Approval::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/base/approvals/'.$approval->id,
            $editedApproval
        );

        $this->assertApiResponse($editedApproval);
    }

    /**
     * @test
     */
    public function test_delete_approval()
    {
        $approval = Approval::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/base/approvals/'.$approval->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/base/approvals/'.$approval->id
        );

        $this->response->assertStatus(404);
    }
}
