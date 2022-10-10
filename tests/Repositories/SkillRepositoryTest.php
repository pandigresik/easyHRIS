<?php namespace Tests\Repositories;

use App\Models\Hr\Skill;
use App\Repositories\Hr\SkillRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class SkillRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var SkillRepository
     */
    protected $skillRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->skillRepo = \App::make(SkillRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_skill()
    {
        $skill = Skill::factory()->make()->toArray();

        $createdSkill = $this->skillRepo->create($skill);

        $createdSkill = $createdSkill->toArray();
        $this->assertArrayHasKey('id', $createdSkill);
        $this->assertNotNull($createdSkill['id'], 'Created Skill must have id specified');
        $this->assertNotNull(Skill::find($createdSkill['id']), 'Skill with given id must be in DB');
        $this->assertModelData($skill, $createdSkill);
    }

    /**
     * @test read
     */
    public function test_read_skill()
    {
        $skill = Skill::factory()->create();

        $dbSkill = $this->skillRepo->find($skill->id);

        $dbSkill = $dbSkill->toArray();
        $this->assertModelData($skill->toArray(), $dbSkill);
    }

    /**
     * @test update
     */
    public function test_update_skill()
    {
        $skill = Skill::factory()->create();
        $fakeSkill = Skill::factory()->make()->toArray();

        $updatedSkill = $this->skillRepo->update($fakeSkill, $skill->id);

        $this->assertModelData($fakeSkill, $updatedSkill->toArray());
        $dbSkill = $this->skillRepo->find($skill->id);
        $this->assertModelData($fakeSkill, $dbSkill->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_skill()
    {
        $skill = Skill::factory()->create();

        $resp = $this->skillRepo->delete($skill->id);

        $this->assertTrue($resp);
        $this->assertNull(Skill::find($skill->id), 'Skill should not exist in DB');
    }
}
