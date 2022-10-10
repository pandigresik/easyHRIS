<?php namespace Tests\Repositories;

use App\Models\Base\Region;
use App\Repositories\Base\RegionRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RegionRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RegionRepository
     */
    protected $regionRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->regionRepo = \App::make(RegionRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_region()
    {
        $region = Region::factory()->make()->toArray();

        $createdRegion = $this->regionRepo->create($region);

        $createdRegion = $createdRegion->toArray();
        $this->assertArrayHasKey('id', $createdRegion);
        $this->assertNotNull($createdRegion['id'], 'Created Region must have id specified');
        $this->assertNotNull(Region::find($createdRegion['id']), 'Region with given id must be in DB');
        $this->assertModelData($region, $createdRegion);
    }

    /**
     * @test read
     */
    public function test_read_region()
    {
        $region = Region::factory()->create();

        $dbRegion = $this->regionRepo->find($region->id);

        $dbRegion = $dbRegion->toArray();
        $this->assertModelData($region->toArray(), $dbRegion);
    }

    /**
     * @test update
     */
    public function test_update_region()
    {
        $region = Region::factory()->create();
        $fakeRegion = Region::factory()->make()->toArray();

        $updatedRegion = $this->regionRepo->update($fakeRegion, $region->id);

        $this->assertModelData($fakeRegion, $updatedRegion->toArray());
        $dbRegion = $this->regionRepo->find($region->id);
        $this->assertModelData($fakeRegion, $dbRegion->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_region()
    {
        $region = Region::factory()->create();

        $resp = $this->regionRepo->delete($region->id);

        $this->assertTrue($resp);
        $this->assertNull(Region::find($region->id), 'Region should not exist in DB');
    }
}
