<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\SkillGroup;

class SkillGroupApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_skill_group()
    {
        $skillGroup = SkillGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/skill_groups', $skillGroup
        );

        $this->assertApiResponse($skillGroup);
    }

    /**
     * @test
     */
    public function test_read_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/skill_groups/'.$skillGroup->id
        );

        $this->assertApiResponse($skillGroup->toArray());
    }

    /**
     * @test
     */
    public function test_update_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();
        $editedSkillGroup = SkillGroup::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/skill_groups/'.$skillGroup->id,
            $editedSkillGroup
        );

        $this->assertApiResponse($editedSkillGroup);
    }

    /**
     * @test
     */
    public function test_delete_skill_group()
    {
        $skillGroup = SkillGroup::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/skill_groups/'.$skillGroup->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/skill_groups/'.$skillGroup->id
        );

        $this->response->assertStatus(404);
    }
}
