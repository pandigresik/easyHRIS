<?php namespace Tests\Repositories;

use App\Models\Accounting\TaxGroupHistory;
use App\Repositories\Accounting\TaxGroupHistoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TaxGroupHistoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TaxGroupHistoryRepository
     */
    protected $taxGroupHistoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->taxGroupHistoryRepo = \App::make(TaxGroupHistoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->make()->toArray();

        $createdTaxGroupHistory = $this->taxGroupHistoryRepo->create($taxGroupHistory);

        $createdTaxGroupHistory = $createdTaxGroupHistory->toArray();
        $this->assertArrayHasKey('id', $createdTaxGroupHistory);
        $this->assertNotNull($createdTaxGroupHistory['id'], 'Created TaxGroupHistory must have id specified');
        $this->assertNotNull(TaxGroupHistory::find($createdTaxGroupHistory['id']), 'TaxGroupHistory with given id must be in DB');
        $this->assertModelData($taxGroupHistory, $createdTaxGroupHistory);
    }

    /**
     * @test read
     */
    public function test_read_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->create();

        $dbTaxGroupHistory = $this->taxGroupHistoryRepo->find($taxGroupHistory->id);

        $dbTaxGroupHistory = $dbTaxGroupHistory->toArray();
        $this->assertModelData($taxGroupHistory->toArray(), $dbTaxGroupHistory);
    }

    /**
     * @test update
     */
    public function test_update_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->create();
        $fakeTaxGroupHistory = TaxGroupHistory::factory()->make()->toArray();

        $updatedTaxGroupHistory = $this->taxGroupHistoryRepo->update($fakeTaxGroupHistory, $taxGroupHistory->id);

        $this->assertModelData($fakeTaxGroupHistory, $updatedTaxGroupHistory->toArray());
        $dbTaxGroupHistory = $this->taxGroupHistoryRepo->find($taxGroupHistory->id);
        $this->assertModelData($fakeTaxGroupHistory, $dbTaxGroupHistory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tax_group_history()
    {
        $taxGroupHistory = TaxGroupHistory::factory()->create();

        $resp = $this->taxGroupHistoryRepo->delete($taxGroupHistory->id);

        $this->assertTrue($resp);
        $this->assertNull(TaxGroupHistory::find($taxGroupHistory->id), 'TaxGroupHistory should not exist in DB');
    }
}
