<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\EducationTitle;

class EducationTitleApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_education_title()
    {
        $educationTitle = EducationTitle::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/education_titles', $educationTitle
        );

        $this->assertApiResponse($educationTitle);
    }

    /**
     * @test
     */
    public function test_read_education_title()
    {
        $educationTitle = EducationTitle::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/education_titles/'.$educationTitle->id
        );

        $this->assertApiResponse($educationTitle->toArray());
    }

    /**
     * @test
     */
    public function test_update_education_title()
    {
        $educationTitle = EducationTitle::factory()->create();
        $editedEducationTitle = EducationTitle::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/education_titles/'.$educationTitle->id,
            $editedEducationTitle
        );

        $this->assertApiResponse($editedEducationTitle);
    }

    /**
     * @test
     */
    public function test_delete_education_title()
    {
        $educationTitle = EducationTitle::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/education_titles/'.$educationTitle->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/education_titles/'.$educationTitle->id
        );

        $this->response->assertStatus(404);
    }
}
