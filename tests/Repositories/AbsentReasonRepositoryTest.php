<?php namespace Tests\Repositories;

use App\Models\Hr\AbsentReason;
use App\Repositories\Hr\AbsentReasonRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class AbsentReasonRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var AbsentReasonRepository
     */
    protected $absentReasonRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->absentReasonRepo = \App::make(AbsentReasonRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_absent_reason()
    {
        $absentReason = AbsentReason::factory()->make()->toArray();

        $createdAbsentReason = $this->absentReasonRepo->create($absentReason);

        $createdAbsentReason = $createdAbsentReason->toArray();
        $this->assertArrayHasKey('id', $createdAbsentReason);
        $this->assertNotNull($createdAbsentReason['id'], 'Created AbsentReason must have id specified');
        $this->assertNotNull(AbsentReason::find($createdAbsentReason['id']), 'AbsentReason with given id must be in DB');
        $this->assertModelData($absentReason, $createdAbsentReason);
    }

    /**
     * @test read
     */
    public function test_read_absent_reason()
    {
        $absentReason = AbsentReason::factory()->create();

        $dbAbsentReason = $this->absentReasonRepo->find($absentReason->id);

        $dbAbsentReason = $dbAbsentReason->toArray();
        $this->assertModelData($absentReason->toArray(), $dbAbsentReason);
    }

    /**
     * @test update
     */
    public function test_update_absent_reason()
    {
        $absentReason = AbsentReason::factory()->create();
        $fakeAbsentReason = AbsentReason::factory()->make()->toArray();

        $updatedAbsentReason = $this->absentReasonRepo->update($fakeAbsentReason, $absentReason->id);

        $this->assertModelData($fakeAbsentReason, $updatedAbsentReason->toArray());
        $dbAbsentReason = $this->absentReasonRepo->find($absentReason->id);
        $this->assertModelData($fakeAbsentReason, $dbAbsentReason->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_absent_reason()
    {
        $absentReason = AbsentReason::factory()->create();

        $resp = $this->absentReasonRepo->delete($absentReason->id);

        $this->assertTrue($resp);
        $this->assertNull(AbsentReason::find($absentReason->id), 'AbsentReason should not exist in DB');
    }
}
