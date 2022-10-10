<?php namespace Tests\Repositories;

use App\Models\Hr\Employee;
use App\Repositories\Hr\EmployeeRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class EmployeeRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var EmployeeRepository
     */
    protected $employeeRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->employeeRepo = \App::make(EmployeeRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_employee()
    {
        $employee = Employee::factory()->make()->toArray();

        $createdEmployee = $this->employeeRepo->create($employee);

        $createdEmployee = $createdEmployee->toArray();
        $this->assertArrayHasKey('id', $createdEmployee);
        $this->assertNotNull($createdEmployee['id'], 'Created Employee must have id specified');
        $this->assertNotNull(Employee::find($createdEmployee['id']), 'Employee with given id must be in DB');
        $this->assertModelData($employee, $createdEmployee);
    }

    /**
     * @test read
     */
    public function test_read_employee()
    {
        $employee = Employee::factory()->create();

        $dbEmployee = $this->employeeRepo->find($employee->id);

        $dbEmployee = $dbEmployee->toArray();
        $this->assertModelData($employee->toArray(), $dbEmployee);
    }

    /**
     * @test update
     */
    public function test_update_employee()
    {
        $employee = Employee::factory()->create();
        $fakeEmployee = Employee::factory()->make()->toArray();

        $updatedEmployee = $this->employeeRepo->update($fakeEmployee, $employee->id);

        $this->assertModelData($fakeEmployee, $updatedEmployee->toArray());
        $dbEmployee = $this->employeeRepo->find($employee->id);
        $this->assertModelData($fakeEmployee, $dbEmployee->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_employee()
    {
        $employee = Employee::factory()->create();

        $resp = $this->employeeRepo->delete($employee->id);

        $this->assertTrue($resp);
        $this->assertNull(Employee::find($employee->id), 'Employee should not exist in DB');
    }
}
