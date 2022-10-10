<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Accounting\Tax;

class TaxApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tax()
    {
        $tax = Tax::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/accounting/taxes', $tax
        );

        $this->assertApiResponse($tax);
    }

    /**
     * @test
     */
    public function test_read_tax()
    {
        $tax = Tax::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/accounting/taxes/'.$tax->id
        );

        $this->assertApiResponse($tax->toArray());
    }

    /**
     * @test
     */
    public function test_update_tax()
    {
        $tax = Tax::factory()->create();
        $editedTax = Tax::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/accounting/taxes/'.$tax->id,
            $editedTax
        );

        $this->assertApiResponse($editedTax);
    }

    /**
     * @test
     */
    public function test_delete_tax()
    {
        $tax = Tax::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/accounting/taxes/'.$tax->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/accounting/taxes/'.$tax->id
        );

        $this->response->assertStatus(404);
    }
}
