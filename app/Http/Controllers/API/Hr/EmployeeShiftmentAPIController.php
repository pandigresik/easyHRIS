<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateEmployeeShiftmentAPIRequest;
use App\Http\Requests\API\Hr\UpdateEmployeeShiftmentAPIRequest;
use App\Models\Hr\EmployeeShiftment;
use App\Repositories\Hr\EmployeeShiftmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\EmployeeShiftmentResource;
use Response;

/**
 * Class EmployeeShiftmentController
 * @package App\Http\Controllers\API\Hr
 */

class EmployeeShiftmentAPIController extends AppBaseController
{
    /** @var  EmployeeShiftmentRepository */
    private $employeeShiftmentRepository;

    public function __construct(EmployeeShiftmentRepository $employeeShiftmentRepo)
    {
        $this->employeeShiftmentRepository = $employeeShiftmentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/employeeShiftments",
     *      summary="Get a listing of the EmployeeShiftments.",
     *      tags={"EmployeeShiftment"},
     *      description="Get all EmployeeShiftments",
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
     *                  @SWG\Items(ref="#/definitions/EmployeeShiftment")
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
        $employeeShiftments = $this->employeeShiftmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EmployeeShiftmentResource::collection($employeeShiftments), 'Employee Shiftments retrieved successfully');
    }

    /**
     * @param CreateEmployeeShiftmentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/employeeShiftments",
     *      summary="Store a newly created EmployeeShiftment in storage",
     *      tags={"EmployeeShiftment"},
     *      description="Store EmployeeShiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EmployeeShiftment that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EmployeeShiftment")
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
     *                  ref="#/definitions/EmployeeShiftment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEmployeeShiftmentAPIRequest $request)
    {
        $input = $request->all();

        $employeeShiftment = $this->employeeShiftmentRepository->create($input);

        return $this->sendResponse(new EmployeeShiftmentResource($employeeShiftment), 'Employee Shiftment saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/employeeShiftments/{id}",
     *      summary="Display the specified EmployeeShiftment",
     *      tags={"EmployeeShiftment"},
     *      description="Get EmployeeShiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmployeeShiftment",
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
     *                  ref="#/definitions/EmployeeShiftment"
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
        /** @var EmployeeShiftment $employeeShiftment */
        $employeeShiftment = $this->employeeShiftmentRepository->find($id);

        if (empty($employeeShiftment)) {
            return $this->sendError('Employee Shiftment not found');
        }

        return $this->sendResponse(new EmployeeShiftmentResource($employeeShiftment), 'Employee Shiftment retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEmployeeShiftmentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/employeeShiftments/{id}",
     *      summary="Update the specified EmployeeShiftment in storage",
     *      tags={"EmployeeShiftment"},
     *      description="Update EmployeeShiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmployeeShiftment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EmployeeShiftment that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EmployeeShiftment")
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
     *                  ref="#/definitions/EmployeeShiftment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEmployeeShiftmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var EmployeeShiftment $employeeShiftment */
        $employeeShiftment = $this->employeeShiftmentRepository->find($id);

        if (empty($employeeShiftment)) {
            return $this->sendError('Employee Shiftment not found');
        }

        $employeeShiftment = $this->employeeShiftmentRepository->update($input, $id);

        return $this->sendResponse(new EmployeeShiftmentResource($employeeShiftment), 'EmployeeShiftment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/employeeShiftments/{id}",
     *      summary="Remove the specified EmployeeShiftment from storage",
     *      tags={"EmployeeShiftment"},
     *      description="Delete EmployeeShiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EmployeeShiftment",
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
        /** @var EmployeeShiftment $employeeShiftment */
        $employeeShiftment = $this->employeeShiftmentRepository->find($id);

        if (empty($employeeShiftment)) {
            return $this->sendError('Employee Shiftment not found');
        }

        $employeeShiftment->delete();

        return $this->sendSuccess('Employee Shiftment deleted successfully');
    }
}
