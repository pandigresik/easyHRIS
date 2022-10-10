<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Accounting\TaxGroupHistory;

class TaxGroupHistoryApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/accounting/tax_group_histories', $taxGroupHistory
        );

        $this->assertApiResponse($taxGroupHistory);
    }

    /**
     * @test
     */
    public function test_read_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/accounting/tax_group_histories/'.$taxGroupHistory->id
        );

        $this->assertApiResponse($taxGroupHistory->toArray());
    }

    /**
     * @test
     */
    public function test_update_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->create();
        $editedTaxGroupHistory = TaxGroupHistory::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/accounting/tax_group_histories/'.$taxGroupHistory->id,
            $editedTaxGroupHistory
        );

        $this->assertApiResponse($editedTaxGroupHistory);
    }

    /**
     * @test
     */
    public function test_delete_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/accounting/tax_group_histories/'.$taxGroupHistory->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/accounting/tax_group_histories/'.$taxGroupHistory->id
        );

        $this->response->assertStatus(404);
    }
}
