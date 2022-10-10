<?php namespace Tests\Repositories;

use App\Models\Accounting\Tax;
use App\Repositories\Accounting\TaxRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class TaxRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var TaxRepository
     */
    protected $taxRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->taxRepo = \App::make(TaxRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_tax()
    {
        $tax = Tax::factory()->make()->toArray();

        $createdTax = $this->taxRepo->create($tax);

        $createdTax = $createdTax->toArray();
        $this->assertArrayHasKey('id', $createdTax);
        $this->assertNotNull($createdTax['id'], 'Created Tax must have id specified');
        $this->assertNotNull(Tax::find($createdTax['id']), 'Tax with given id must be in DB');
        $this->assertModelData($tax, $createdTax);
    }

    /**
     * @test read
     */
    public function test_read_tax()
    {
        $tax = Tax::factory()->create();

        $dbTax = $this->taxRepo->find($tax->id);

        $dbTax = $dbTax->toArray();
        $this->assertModelData($tax->toArray(), $dbTax);
    }

    /**
     * @test update
     */
    public function test_update_tax()
    {
        $tax = Tax::factory()->create();
        $fakeTax = Tax::factory()->make()->toArray();

        $updatedTax = $this->taxRepo->update($fakeTax, $tax->id);

        $this->assertModelData($fakeTax, $updatedTax->toArray());
        $dbTax = $this->taxRepo->find($tax->id);
        $this->assertModelData($fakeTax, $dbTax->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_tax()
    {
        $tax = Tax::factory()->create();

        $resp = $this->taxRepo->delete($tax->id);

        $this->assertTrue($resp);
        $this->assertNull(Tax::find($tax->id), 'Tax should not exist in DB');
    }
}
