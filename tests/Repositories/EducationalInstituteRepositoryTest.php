<?php namespace Tests\Repositories;

use App\Models\Hr\EducationalInstitute;
use App\Repositories\Hr\EducationalInstituteRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EducationalInstituteRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EducationalInstituteRepository
     */
    protected $educationalInstituteRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->educationalInstituteRepo = \App::make(EducationalInstituteRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->make()->toArray();

        $createdEducationalInstitute = $this->educationalInstituteRepo->create($educationalInstitute);

        $createdEducationalInstitute = $createdEducationalInstitute->toArray();
        $this->assertArrayHasKey('id', $createdEducationalInstitute);
        $this->assertNotNull($createdEducationalInstitute['id'], 'Created EducationalInstitute must have id specified');
        $this->assertNotNull(EducationalInstitute::find($createdEducationalInstitute['id']), 'EducationalInstitute with given id must be in DB');
        $this->assertModelData($educationalInstitute, $createdEducationalInstitute);
    }

    /**
     * @test read
     */
    public function test_read_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->create();

        $dbEducationalInstitute = $this->educationalInstituteRepo->find($educationalInstitute->id);

        $dbEducationalInstitute = $dbEducationalInstitute->toArray();
        $this->assertModelData($educationalInstitute->toArray(), $dbEducationalInstitute);
    }

    /**
     * @test update
     */
    public function test_update_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->create();
        $fakeEducationalInstitute = EducationalInstitute::factory()->make()->toArray();

        $updatedEducationalInstitute = $this->educationalInstituteRepo->update($fakeEducationalInstitute, $educationalInstitute->id);

        $this->assertModelData($fakeEducationalInstitute, $updatedEducationalInstitute->toArray());
        $dbEducationalInstitute = $this->educationalInstituteRepo->find($educationalInstitute->id);
        $this->assertModelData($fakeEducationalInstitute, $dbEducationalInstitute->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_educational_institute()
    {
        $educationalInstitute = EducationalInstitute::factory()->create();

        $resp = $this->educationalInstituteRepo->delete($educationalInstitute->id);

        $this->assertTrue($resp);
        $this->assertNull(EducationalInstitute::find($educationalInstitute->id), 'EducationalInstitute should not exist in DB');
    }
}
