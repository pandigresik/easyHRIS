<?php namespace Tests\Repositories;

use App\Models\Base\Approval;
use App\Repositories\Base\ApprovalRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ApprovalRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var ApprovalRepository
     */
    protected $approvalRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->approvalRepo = \App::make(ApprovalRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_approval()
    {
        $approval = Approval::factory()->make()->toArray();

        $createdApproval = $this->approvalRepo->create($approval);

        $createdApproval = $createdApproval->toArray();
        $this->assertArrayHasKey('id', $createdApproval);
        $this->assertNotNull($createdApproval['id'], 'Created Approval must have id specified');
        $this->assertNotNull(Approval::find($createdApproval['id']), 'Approval with given id must be in DB');
        $this->assertModelData($approval, $createdApproval);
    }

    /**
     * @test read
     */
    public function test_read_approval()
    {
        $approval = Approval::factory()->create();

        $dbApproval = $this->approvalRepo->find($approval->id);

        $dbApproval = $dbApproval->toArray();
        $this->assertModelData($approval->toArray(), $dbApproval);
    }

    /**
     * @test update
     */
    public function test_update_approval()
    {
        $approval = Approval::factory()->create();
        $fakeApproval = Approval::factory()->make()->toArray();

        $updatedApproval = $this->approvalRepo->update($fakeApproval, $approval->id);

        $this->assertModelData($fakeApproval, $updatedApproval->toArray());
        $dbApproval = $this->approvalRepo->find($approval->id);
        $this->assertModelData($fakeApproval, $dbApproval->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_approval()
    {
        $approval = Approval::factory()->create();

        $resp = $this->approvalRepo->delete($approval->id);

        $this->assertTrue($resp);
        $this->assertNull(Approval::find($approval->id), 'Approval should not exist in DB');
    }
}
