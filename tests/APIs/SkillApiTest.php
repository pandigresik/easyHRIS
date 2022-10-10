<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\Skill;

class SkillApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_skill()
    {
        $skill = Skill::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/skills', $skill
        );

        $this->assertApiResponse($skill);
    }

    /**
     * @test
     */
    public function test_read_skill()
    {
        $skill = Skill::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/skills/'.$skill->id
        );

        $this->assertApiResponse($skill->toArray());
    }

    /**
     * @test
     */
    public function test_update_skill()
    {
        $skill = Skill::factory()->create();
        $editedSkill = Skill::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/skills/'.$skill->id,
            $editedSkill
        );

        $this->assertApiResponse($editedSkill);
    }

    /**
     * @test
     */
    public function test_delete_skill()
    {
        $skill = Skill::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/skills/'.$skill->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/skills/'.$skill->id
        );

        $this->response->assertStatus(404);
    }
}
