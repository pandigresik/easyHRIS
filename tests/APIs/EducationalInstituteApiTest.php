<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\EducationalInstitute;

class EducationalInstituteApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/educational_institutes', $educationalInstitute
        );

        $this->assertApiResponse($educationalInstitute);
    }

    /**
     * @test
     */
    public function test_read_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/educational_institutes/'.$educationalInstitute->id
        );

        $this->assertApiResponse($educationalInstitute->toArray());
    }

    /**
     * @test
     */
    public function test_update_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->create();
        $editedEducationalInstitute = EducationalInstitute::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/educational_institutes/'.$educationalInstitute->id,
            $editedEducationalInstitute
        );

        $this->assertApiResponse($editedEducationalInstitute);
    }

    /**
     * @test
     */
    public function test_delete_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/educational_institutes/'.$educationalInstitute->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/educational_institutes/'.$educationalInstitute->id
        );

        $this->response->assertStatus(404);
    }
}
