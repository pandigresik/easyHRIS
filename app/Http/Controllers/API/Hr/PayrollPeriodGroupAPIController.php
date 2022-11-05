<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreatePayrollPeriodGroupAPIRequest;
use App\Http\Requests\API\Hr\UpdatePayrollPeriodGroupAPIRequest;
use App\Models\Hr\PayrollPeriodGroup;
use App\Repositories\Hr\PayrollPeriodGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\PayrollPeriodGroupResource;
use Response;

/**
 * Class PayrollPeriodGroupController
 * @package App\Http\Controllers\API\Hr
 */

class PayrollPeriodGroupAPIController extends AppBaseController
{
    /** @var  PayrollPeriodGroupRepository */
    private $payrollPeriodGroupRepository;

    public function __construct(PayrollPeriodGroupRepository $payrollPeriodGroupRepo)
    {
        $this->payrollPeriodGroupRepository = $payrollPeriodGroupRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrollPeriodGroups",
     *      summary="Get a listing of the PayrollPeriodGroups.",
     *      tags={"PayrollPeriodGroup"},
     *      description="Get all PayrollPeriodGroups",
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
     *                  @SWG\Items(ref="#/definitions/PayrollPeriodGroup")
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
        $payrollPeriodGroups = $this->payrollPeriodGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PayrollPeriodGroupResource::collection($payrollPeriodGroups), 'Payroll Period Groups retrieved successfully');
    }

    /**
     * @param CreatePayrollPeriodGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/payrollPeriodGroups",
     *      summary="Store a newly created PayrollPeriodGroup in storage",
     *      tags={"PayrollPeriodGroup"},
     *      description="Store PayrollPeriodGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PayrollPeriodGroup that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PayrollPeriodGroup")
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
     *                  ref="#/definitions/PayrollPeriodGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePayrollPeriodGroupAPIRequest $request)
    {
        $input = $request->all();

        $payrollPeriodGroup = $this->payrollPeriodGroupRepository->create($input);

        return $this->sendResponse(new PayrollPeriodGroupResource($payrollPeriodGroup), 'Payroll Period Group saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrollPeriodGroups/{id}",
     *      summary="Display the specified PayrollPeriodGroup",
     *      tags={"PayrollPeriodGroup"},
     *      description="Get PayrollPeriodGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollPeriodGroup",
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
     *                  ref="#/definitions/PayrollPeriodGroup"
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
        /** @var PayrollPeriodGroup $payrollPeriodGroup */
        $payrollPeriodGroup = $this->payrollPeriodGroupRepository->find($id);

        if (empty($payrollPeriodGroup)) {
            return $this->sendError('Payroll Period Group not found');
        }

        return $this->sendResponse(new PayrollPeriodGroupResource($payrollPeriodGroup), 'Payroll Period Group retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePayrollPeriodGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/payrollPeriodGroups/{id}",
     *      summary="Update the specified PayrollPeriodGroup in storage",
     *      tags={"PayrollPeriodGroup"},
     *      description="Update PayrollPeriodGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollPeriodGroup",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PayrollPeriodGroup that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PayrollPeriodGroup")
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
     *                  ref="#/definitions/PayrollPeriodGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePayrollPeriodGroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var PayrollPeriodGroup $payrollPeriodGroup */
        $payrollPeriodGroup = $this->payrollPeriodGroupRepository->find($id);

        if (empty($payrollPeriodGroup)) {
            return $this->sendError('Payroll Period Group not found');
        }

        $payrollPeriodGroup = $this->payrollPeriodGroupRepository->update($input, $id);

        return $this->sendResponse(new PayrollPeriodGroupResource($payrollPeriodGroup), 'PayrollPeriodGroup updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/payrollPeriodGroups/{id}",
     *      summary="Remove the specified PayrollPeriodGroup from storage",
     *      tags={"PayrollPeriodGroup"},
     *      description="Delete PayrollPeriodGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollPeriodGroup",
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
        /** @var PayrollPeriodGroup $payrollPeriodGroup */
        $payrollPeriodGroup = $this->payrollPeriodGroupRepository->find($id);

        if (empty($payrollPeriodGroup)) {
            return $this->sendError('Payroll Period Group not found');
        }

        $payrollPeriodGroup->delete();

        return $this->sendSuccess('Payroll Period Group deleted successfully');
    }
}
