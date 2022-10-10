<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Hr\EmployeeShiftment;

class EmployeeShiftmentApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/hr/employee_shiftments', $employeeShiftment
        );

        $this->assertApiResponse($employeeShiftment);
    }

    /**
     * @test
     */
    public function test_read_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/hr/employee_shiftments/'.$employeeShiftment->id
        );

        $this->assertApiResponse($employeeShiftment->toArray());
    }

    /**
     * @test
     */
    public function test_update_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->create();
        $editedEmployeeShiftment = EmployeeShiftment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/hr/employee_shiftments/'.$employeeShiftment->id,
            $editedEmployeeShiftment
        );

        $this->assertApiResponse($editedEmployeeShiftment);
    }

    /**
     * @test
     */
    public function test_delete_employee_shiftment()
    {
        $employeeShiftment = EmployeeShiftment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/hr/employee_shiftments/'.$employeeShiftment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/hr/employee_shiftments/'.$employeeShiftment->id
        );

        $this->response->assertStatus(404);
    }
}
