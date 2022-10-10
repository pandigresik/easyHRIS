<?php namespace Tests\Repositories;

use App\Models\Hr\EmployeeShiftment;
use App\Repositories\Hr\EmployeeShiftmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EmployeeShiftmentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EmployeeShiftmentRepository
     */
    protected $employeeShiftmentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->employeeShiftmentRepo = \App::make(EmployeeShiftmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->make()->toArray();

        $createdEmployeeShiftment = $this->employeeShiftmentRepo->create($employeeShiftment);

        $createdEmployeeShiftment = $createdEmployeeShiftment->toArray();
        $this->assertArrayHasKey('id', $createdEmployeeShiftment);
        $this->assertNotNull($createdEmployeeShiftment['id'], 'Created EmployeeShiftment must have id specified');
        $this->assertNotNull(EmployeeShiftment::find($createdEmployeeShiftment['id']), 'EmployeeShiftment with given id must be in DB');
        $this->assertModelData($employeeShiftment, $createdEmployeeShiftment);
    }

    /**
     * @test read
     */
    public function test_read_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->create();

        $dbEmployeeShiftment = $this->employeeShiftmentRepo->find($employeeShiftment->id);

        $dbEmployeeShiftment = $dbEmployeeShiftment->toArray();
        $this->assertModelData($employeeShiftment->toArray(), $dbEmployeeShiftment);
    }

    /**
     * @test update
     */
    public function test_update_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->create();
        $fakeEmployeeShiftment = EmployeeShiftment::factory()->make()->toArray();

        $updatedEmployeeShiftment = $this->employeeShiftmentRepo->update($fakeEmployeeShiftment, $employeeShiftment->id);

        $this->assertModelData($fakeEmployeeShiftment, $updatedEmployeeShiftment->toArray());
        $dbEmployeeShiftment = $this->employeeShiftmentRepo->find($employeeShiftment->id);
        $this->assertModelData($fakeEmployeeShiftment, $dbEmployeeShiftment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->create();

        $resp = $this->employeeShiftmentRepo->delete($employeeShiftment->id);

        $this->assertTrue($resp);
        $this->assertNull(EmployeeShiftment::find($employeeShiftment->id), 'EmployeeShiftment should not exist in DB');
    }
}
