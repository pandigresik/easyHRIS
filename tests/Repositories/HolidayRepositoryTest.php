<?php namespace Tests\Repositories;

use App\Models\Hr\Holiday;
use App\Repositories\Hr\HolidayRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class HolidayRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var HolidayRepository
     */
    protected $holidayRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->holidayRepo = \App::make(HolidayRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_holiday()
    {
        $holiday = Holiday::factory()->make()->toArray();

        $createdHoliday = $this->holidayRepo->create($holiday);

        $createdHoliday = $createdHoliday->toArray();
        $this->assertArrayHasKey('id', $createdHoliday);
        $this->assertNotNull($createdHoliday['id'], 'Created Holiday must have id specified');
        $this->assertNotNull(Holiday::find($createdHoliday['id']), 'Holiday with given id must be in DB');
        $this->assertModelData($holiday, $createdHoliday);
    }

    /**
     * @test read
     */
    public function test_read_holiday()
    {
        $holiday = Holiday::factory()->create();

        $dbHoliday = $this->holidayRepo->find($holiday->id);

        $dbHoliday = $dbHoliday->toArray();
        $this->assertModelData($holiday->toArray(), $dbHoliday);
    }

    /**
     * @test update
     */
    public function test_update_holiday()
    {
        $holiday = Holiday::factory()->create();
        $fakeHoliday = Holiday::factory()->make()->toArray();

        $updatedHoliday = $this->holidayRepo->update($fakeHoliday, $holiday->id);

        $this->assertModelData($fakeHoliday, $updatedHoliday->toArray());
        $dbHoliday = $this->holidayRepo->find($holiday->id);
        $this->assertModelData($fakeHoliday, $dbHoliday->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_holiday()
    {
        $holiday = Holiday::factory()->create();

        $resp = $this->holidayRepo->delete($holiday->id);

        $this->assertTrue($resp);
        $this->assertNull(Holiday::find($holiday->id), 'Holiday should not exist in DB');
    }
}
