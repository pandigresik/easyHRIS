<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Contract;

class ContractApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_contract()
    {
        $contract = Contract::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/contracts', $contract
        );

        $this->assertApiResponse($contract);
    }

    /**
     * @test
     */
    public function test_read_contract()
    {
        $contract = Contract::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/contracts/'.$contract->id
        );

        $this->assertApiResponse($contract->toArray());
    }

    /**
     * @test
     */
    public function test_update_contract()
    {
        $contract = Contract::factory()->create();
        $editedContract = Contract::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/contracts/'.$contract->id,
            $editedContract
        );

        $this->assertApiResponse($editedContract);
    }

    /**
     * @test
     */
    public function test_delete_contract()
    {
        $contract = Contract::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/contracts/'.$contract->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/contracts/'.$contract->id
        );

        $this->response->assertStatus(404);
    }
}
