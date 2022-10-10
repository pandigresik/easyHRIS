<?php namespace Tests\Repositories;

use App\Models\Hr\SkillGroup;
use App\Repositories\Hr\SkillGroupRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SkillGroupRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SkillGroupRepository
     */
    protected $skillGroupRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->skillGroupRepo = \App::make(SkillGroupRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_skill_group()
    {
        $skillGroup = SkillGroup::factory()->make()->toArray();

        $createdSkillGroup = $this->skillGroupRepo->create($skillGroup);

        $createdSkillGroup = $createdSkillGroup->toArray();
        $this->assertArrayHasKey('id', $createdSkillGroup);
        $this->assertNotNull($createdSkillGroup['id'], 'Created SkillGroup must have id specified');
        $this->assertNotNull(SkillGroup::find($createdSkillGroup['id']), 'SkillGroup with given id must be in DB');
        $this->assertModelData($skillGroup, $createdSkillGroup);
    }

    /**
     * @test read
     */
    public function test_read_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $dbSkillGroup = $this->skillGroupRepo->find($skillGroup->id);

        $dbSkillGroup = $dbSkillGroup->toArray();
        $this->assertModelData($skillGroup->toArray(), $dbSkillGroup);
    }

    /**
     * @test update
     */
    public function test_update_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();
        $fakeSkillGroup = SkillGroup::factory()->make()->toArray();

        $updatedSkillGroup = $this->skillGroupRepo->update($fakeSkillGroup, $skillGroup->id);

        $this->assertModelData($fakeSkillGroup, $updatedSkillGroup->toArray());
        $dbSkillGroup = $this->skillGroupRepo->find($skillGroup->id);
        $this->assertModelData($fakeSkillGroup, $dbSkillGroup->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $resp = $this->skillGroupRepo->delete($skillGroup->id);

        $this->assertTrue($resp);
        $this->assertNull(SkillGroup::find($skillGroup->id), 'SkillGroup should not exist in DB');
    }
}
