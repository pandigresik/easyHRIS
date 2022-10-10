<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Base\Company;

class CompanyApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_company()
    {
        $company = Company::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/base/companies', $company
        );

        $this->assertApiResponse($company);
    }

    /**
     * @test
     */
    public function test_read_company()
    {
        $company = Company::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/base/companies/'.$company->id
        );

        $this->assertApiResponse($company->toArray());
    }

    /**
     * @test
     */
    public function test_update_company()
    {
        $company = Company::factory()->create();
        $editedCompany = Company::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/base/companies/'.$company->id,
            $editedCompany
        );

        $this->assertApiResponse($editedCompany);
    }

    /**
     * @test
     */
    public function test_delete_company()
    {
        $company = Company::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/base/companies/'.$company->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/base/companies/'.$company->id
        );

        $this->response->assertStatus(404);
    }
}
