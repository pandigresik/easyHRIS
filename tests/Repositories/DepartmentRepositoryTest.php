<?php namespace Tests\Repositories;

use App\Models\Base\Department;
use App\Repositories\Base\DepartmentRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class DepartmentRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var DepartmentRepository
     */
    protected $departmentRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->departmentRepo = \App::make(DepartmentRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_department()
    {
        $department = Department::factory()->make()->toArray();

        $createdDepartment = $this->departmentRepo->create($department);

        $createdDepartment = $createdDepartment->toArray();
        $this->assertArrayHasKey('id', $createdDepartment);
        $this->assertNotNull($createdDepartment['id'], 'Created Department must have id specified');
        $this->assertNotNull(Department::find($createdDepartment['id']), 'Department with given id must be in DB');
        $this->assertModelData($department, $createdDepartment);
    }

    /**
     * @test read
     */
    public function test_read_department()
    {
        $department = Department::factory()->create();

        $dbDepartment = $this->departmentRepo->find($department->id);

        $dbDepartment = $dbDepartment->toArray();
        $this->assertModelData($department->toArray(), $dbDepartment);
    }

    /**
     * @test update
     */
    public function test_update_department()
    {
        $department = Department::factory()->create();
        $fakeDepartment = Department::factory()->make()->toArray();

        $updatedDepartment = $this->departmentRepo->update($fakeDepartment, $department->id);

        $this->assertModelData($fakeDepartment, $updatedDepartment->toArray());
        $dbDepartment = $this->departmentRepo->find($department->id);
        $this->assertModelData($fakeDepartment, $dbDepartment->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_department()
    {
        $department = Department::factory()->create();

        $resp = $this->departmentRepo->delete($department->id);

        $this->assertTrue($resp);
        $this->assertNull(Department::find($department->id), 'Department should not exist in DB');
    }
}
