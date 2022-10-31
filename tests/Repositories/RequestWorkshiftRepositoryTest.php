<?php namespace Tests\Repositories;

use App\Models\Hr\RequestWorkshift;
use App\Repositories\Hr\RequestWorkshiftRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class RequestWorkshiftRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var RequestWorkshiftRepository
     */
    protected $requestWorkshiftRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->requestWorkshiftRepo = \App::make(RequestWorkshiftRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->make()->toArray();

        $createdRequestWorkshift = $this->requestWorkshiftRepo->create($requestWorkshift);

        $createdRequestWorkshift = $createdRequestWorkshift->toArray();
        $this->assertArrayHasKey('id', $createdRequestWorkshift);
        $this->assertNotNull($createdRequestWorkshift['id'], 'Created RequestWorkshift must have id specified');
        $this->assertNotNull(RequestWorkshift::find($createdRequestWorkshift['id']), 'RequestWorkshift with given id must be in DB');
        $this->assertModelData($requestWorkshift, $createdRequestWorkshift);
    }

    /**
     * @test read
     */
    public function test_read_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->create();

        $dbRequestWorkshift = $this->requestWorkshiftRepo->find($requestWorkshift->id);

        $dbRequestWorkshift = $dbRequestWorkshift->toArray();
        $this->assertModelData($requestWorkshift->toArray(), $dbRequestWorkshift);
    }

    /**
     * @test update
     */
    public function test_update_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->create();
        $fakeRequestWorkshift = RequestWorkshift::factory()->make()->toArray();

        $updatedRequestWorkshift = $this->requestWorkshiftRepo->update($fakeRequestWorkshift, $requestWorkshift->id);

        $this->assertModelData($fakeRequestWorkshift, $updatedRequestWorkshift->toArray());
        $dbRequestWorkshift = $this->requestWorkshiftRepo->find($requestWorkshift->id);
        $this->assertModelData($fakeRequestWorkshift, $dbRequestWorkshift->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_request_workshift()
    {
        $requestWorkshift = RequestWorkshift::factory()->create();

        $resp = $this->requestWorkshiftRepo->delete($requestWorkshift->id);

        $this->assertTrue($resp);
        $this->assertNull(RequestWorkshift::find($requestWorkshift->id), 'RequestWorkshift should not exist in DB');
    }
}
