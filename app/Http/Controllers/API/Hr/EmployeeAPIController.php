<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateEmployeeAPIRequest;
use App\Http\Requests\API\Hr\UpdateEmployeeAPIRequest;
use App\Models\Hr\Employee;
use App\Repositories\Hr\EmployeeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\EmployeeResource;
use Response;

/**
 * Class EmployeeController
 * @package App\Http\Controllers\API\Hr
 */

class EmployeeAPIController extends AppBaseController
{
    /** @var  EmployeeRepository */
    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepo)
    {
        $this->employeeRepository = $employeeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/employees",
     *      summary="Get a listing of the Employees.",
     *      tags={"Employee"},
     *      description="Get all Employees",
     *      produces={"application/json"},
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/Employee")
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request)
    {
        $employees = $this->employeeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EmployeeResource::collection($employees), 'Employees retrieved successfully');
    }

    /**
     * @param CreateEmployeeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/employees",
     *      summary="Store a newly created Employee in storage",
     *      tags={"Employee"},
     *      description="Store Employee",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Employee that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Employee")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Employee"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEmployeeAPIRequest $request)
    {
        $input = $request->all();

        $employee = $this->employeeRepository->create($input);

        return $this->sendResponse(new EmployeeResource($employee), 'Employee saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/employees/{id}",
     *      summary="Display the specified Employee",
     *      tags={"Employee"},
     *      description="Get Employee",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Employee",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Employee"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            return $this->sendError('Employee not found');
        }

        return $this->sendResponse(new EmployeeResource($employee), 'Employee retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEmployeeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/employees/{id}",
     *      summary="Update the specified Employee in storage",
     *      tags={"Employee"},
     *      description="Update Employee",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Employee",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Employee that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Employee")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/Employee"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEmployeeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Employee $employee */
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            return $this->sendError('Employee not found');
        }

        $employee = $this->employeeRepository->update($input, $id);

        return $this->sendResponse(new EmployeeResource($employee), 'Employee updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/employees/{id}",
     *      summary="Remove the specified Employee from storage",
     *      tags={"Employee"},
     *      description="Delete Employee",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Employee",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="successful operation",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @SWG\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        /** @var Employee $employee */
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            return $this->sendError('Employee not found');
        }

        $employee->delete();

        return $this->sendSuccess('Employee deleted successfully');
    }
}
