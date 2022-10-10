<?php namespace Tests\Repositories;

use App\Models\Hr\EducationTitle;
use App\Repositories\Hr\EducationTitleRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EducationTitleRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EducationTitleRepository
     */
    protected $educationTitleRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->educationTitleRepo = \App::make(EducationTitleRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_education_title()
    {
        $educationTitle = EducationTitle::factory()->make()->toArray();

        $createdEducationTitle = $this->educationTitleRepo->create($educationTitle);

        $createdEducationTitle = $createdEducationTitle->toArray();
        $this->assertArrayHasKey('id', $createdEducationTitle);
        $this->assertNotNull($createdEducationTitle['id'], 'Created EducationTitle must have id specified');
        $this->assertNotNull(EducationTitle::find($createdEducationTitle['id']), 'EducationTitle with given id must be in DB');
        $this->assertModelData($educationTitle, $createdEducationTitle);
    }

    /**
     * @test read
     */
    public function test_read_education_title()
    {
        $educationTitle = EducationTitle::factory()->create();

        $dbEducationTitle = $this->educationTitleRepo->find($educationTitle->id);

        $dbEducationTitle = $dbEducationTitle->toArray();
        $this->assertModelData($educationTitle->toArray(), $dbEducationTitle);
    }

    /**
     * @test update
     */
    public function test_update_education_title()
    {
        $educationTitle = EducationTitle::factory()->create();
        $fakeEducationTitle = EducationTitle::factory()->make()->toArray();

        $updatedEducationTitle = $this->educationTitleRepo->update($fakeEducationTitle, $educationTitle->id);

        $this->assertModelData($fakeEducationTitle, $updatedEducationTitle->toArray());
        $dbEducationTitle = $this->educationTitleRepo->find($educationTitle->id);
        $this->assertModelData($fakeEducationTitle, $dbEducationTitle->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_education_title()
    {
        $educationTitle = EducationTitle::factory()->create();

        $resp = $this->educationTitleRepo->delete($educationTitle->id);

        $this->assertTrue($resp);
        $this->assertNull(EducationTitle::find($educationTitle->id), 'EducationTitle should not exist in DB');
    }
}
