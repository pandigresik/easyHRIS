<?php namespace Tests\Repositories;

use App\Models\Hr\Overtime;
use App\Repositories\Hr\OvertimeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class OvertimeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var OvertimeRepository
     */
    protected $overtimeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->overtimeRepo = \App::make(OvertimeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_overtime()
    {
        $overtime = Overtime::factory()->make()->toArray();

        $createdOvertime = $this->overtimeRepo->create($overtime);

        $createdOvertime = $createdOvertime->toArray();
        $this->assertArrayHasKey('id', $createdOvertime);
        $this->assertNotNull($createdOvertime['id'], 'Created Overtime must have id specified');
        $this->assertNotNull(Overtime::find($createdOvertime['id']), 'Overtime with given id must be in DB');
        $this->assertModelData($overtime, $createdOvertime);
    }

    /**
     * @test read
     */
    public function test_read_overtime()
    {
        $overtime = Overtime::factory()->create();

        $dbOvertime = $this->overtimeRepo->find($overtime->id);

        $dbOvertime = $dbOvertime->toArray();
        $this->assertModelData($overtime->toArray(), $dbOvertime);
    }

    /**
     * @test update
     */
    public function test_update_overtime()
    {
        $overtime = Overtime::factory()->create();
        $fakeOvertime = Overtime::factory()->make()->toArray();

        $updatedOvertime = $this->overtimeRepo->update($fakeOvertime, $overtime->id);

        $this->assertModelData($fakeOvertime, $updatedOvertime->toArray());
        $dbOvertime = $this->overtimeRepo->find($overtime->id);
        $this->assertModelData($fakeOvertime, $dbOvertime->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_overtime()
    {
        $overtime = Overtime::factory()->create();

        $resp = $this->overtimeRepo->delete($overtime->id);

        $this->assertTrue($resp);
        $this->assertNull(Overtime::find($overtime->id), 'Overtime should not exist in DB');
    }
}
