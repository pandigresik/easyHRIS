<?php namespace Tests\Repositories;

use App\Models\Hr\Contract;
use App\Repositories\Hr\ContractRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ContractRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ContractRepository
     */
    protected $contractRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->contractRepo = \App::make(ContractRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_contract()
    {
        $contract = Contract::factory()->make()->toArray();

        $createdContract = $this->contractRepo->create($contract);

        $createdContract = $createdContract->toArray();
        $this->assertArrayHasKey('id', $createdContract);
        $this->assertNotNull($createdContract['id'], 'Created Contract must have id specified');
        $this->assertNotNull(Contract::find($createdContract['id']), 'Contract with given id must be in DB');
        $this->assertModelData($contract, $createdContract);
    }

    /**
     * @test read
     */
    public function test_read_contract()
    {
        $contract = Contract::factory()->create();

        $dbContract = $this->contractRepo->find($contract->id);

        $dbContract = $dbContract->toArray();
        $this->assertModelData($contract->toArray(), $dbContract);
    }

    /**
     * @test update
     */
    public function test_update_contract()
    {
        $contract = Contract::factory()->create();
        $fakeContract = Contract::factory()->make()->toArray();

        $updatedContract = $this->contractRepo->update($fakeContract, $contract->id);

        $this->assertModelData($fakeContract, $updatedContract->toArray());
        $dbContract = $this->contractRepo->find($contract->id);
        $this->assertModelData($fakeContract, $dbContract->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_contract()
    {
        $contract = Contract::factory()->create();

        $resp = $this->contractRepo->delete($contract->id);

        $this->assertTrue($resp);
        $this->assertNull(Contract::find($contract->id), 'Contract should not exist in DB');
    }
}
