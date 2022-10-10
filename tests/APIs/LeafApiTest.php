<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Leaf;

class LeafApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_leaf()
    {
        $leaf = Leaf::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/leaves', $leaf
        );

        $this->assertApiResponse($leaf);
    }

    /**
     * @test
     */
    public function test_read_leaf()
    {
        $leaf = Leaf::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/leaves/'.$leaf->id
        );

        $this->assertApiResponse($leaf->toArray());
    }

    /**
     * @test
     */
    public function test_update_leaf()
    {
        $leaf = Leaf::factory()->create();
        $editedLeaf = Leaf::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/leaves/'.$leaf->id,
            $editedLeaf
        );

        $this->assertApiResponse($editedLeaf);
    }

    /**
     * @test
     */
    public function test_delete_leaf()
    {
        $leaf = Leaf::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/leaves/'.$leaf->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/leaves/'.$leaf->id
        );

        $this->response->assertStatus(404);
    }
}
