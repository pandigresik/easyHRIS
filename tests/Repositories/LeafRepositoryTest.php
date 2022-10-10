<?php namespace Tests\Repositories;

use App\Models\Hr\Leaf;
use App\Repositories\Hr\LeafRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class LeafRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var LeafRepository
     */
    protected $leafRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->leafRepo = \App::make(LeafRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_leaf()
    {
        $leaf = Leaf::factory()->make()->toArray();

        $createdLeaf = $this->leafRepo->create($leaf);

        $createdLeaf = $createdLeaf->toArray();
        $this->assertArrayHasKey('id', $createdLeaf);
        $this->assertNotNull($createdLeaf['id'], 'Created Leaf must have id specified');
        $this->assertNotNull(Leaf::find($createdLeaf['id']), 'Leaf with given id must be in DB');
        $this->assertModelData($leaf, $createdLeaf);
    }

    /**
     * @test read
     */
    public function test_read_leaf()
    {
        $leaf = Leaf::factory()->create();

        $dbLeaf = $this->leafRepo->find($leaf->id);

        $dbLeaf = $dbLeaf->toArray();
        $this->assertModelData($leaf->toArray(), $dbLeaf);
    }

    /**
     * @test update
     */
    public function test_update_leaf()
    {
        $leaf = Leaf::factory()->create();
        $fakeLeaf = Leaf::factory()->make()->toArray();

        $updatedLeaf = $this->leafRepo->update($fakeLeaf, $leaf->id);

        $this->assertModelData($fakeLeaf, $updatedLeaf->toArray());
        $dbLeaf = $this->leafRepo->find($leaf->id);
        $this->assertModelData($fakeLeaf, $dbLeaf->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_leaf()
    {
        $leaf = Leaf::factory()->create();

        $resp = $this->leafRepo->delete($leaf->id);

        $this->assertTrue($resp);
        $this->assertNull(Leaf::find($leaf->id), 'Leaf should not exist in DB');
    }
}
