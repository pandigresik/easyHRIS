<?php namespace Tests\Repositories;

use App\Models\Hr\CareerHistory;
use App\Repositories\Hr\CareerHistoryRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class CareerHistoryRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var CareerHistoryRepository
     */
    protected $careerHistoryRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->careerHistoryRepo = \App::make(CareerHistoryRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_career_history()
    {
        $careerHistory = CareerHistory::factory()->make()->toArray();

        $createdCareerHistory = $this->careerHistoryRepo->create($careerHistory);

        $createdCareerHistory = $createdCareerHistory->toArray();
        $this->assertArrayHasKey('id', $createdCareerHistory);
        $this->assertNotNull($createdCareerHistory['id'], 'Created CareerHistory must have id specified');
        $this->assertNotNull(CareerHistory::find($createdCareerHistory['id']), 'CareerHistory with given id must be in DB');
        $this->assertModelData($careerHistory, $createdCareerHistory);
    }

    /**
     * @test read
     */
    public function test_read_career_history()
    {
        $careerHistory = CareerHistory::factory()->create();

        $dbCareerHistory = $this->careerHistoryRepo->find($careerHistory->id);

        $dbCareerHistory = $dbCareerHistory->toArray();
        $this->assertModelData($careerHistory->toArray(), $dbCareerHistory);
    }

    /**
     * @test update
     */
    public function test_update_career_history()
    {
        $careerHistory = CareerHistory::factory()->create();
        $fakeCareerHistory = CareerHistory::factory()->make()->toArray();

        $updatedCareerHistory = $this->careerHistoryRepo->update($fakeCareerHistory, $careerHistory->id);

        $this->assertModelData($fakeCareerHistory, $updatedCareerHistory->toArray());
        $dbCareerHistory = $this->careerHistoryRepo->find($careerHistory->id);
        $this->assertModelData($fakeCareerHistory, $dbCareerHistory->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_career_history()
    {
        $careerHistory = CareerHistory::factory()->create();

        $resp = $this->careerHistoryRepo->delete($careerHistory->id);

        $this->assertTrue($resp);
        $this->assertNull(CareerHistory::find($careerHistory->id), 'CareerHistory should not exist in DB');
    }
}
