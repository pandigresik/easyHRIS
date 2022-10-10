<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreatePayrollAPIRequest;
use App\Http\Requests\API\Hr\UpdatePayrollAPIRequest;
use App\Models\Hr\Payroll;
use App\Repositories\Hr\PayrollRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\PayrollResource;
use Response;

/**
 * Class PayrollController
 * @package App\Http\Controllers\API\Hr
 */

class PayrollAPIController extends AppBaseController
{
    /** @var  PayrollRepository */
    private $payrollRepository;

    public function __construct(PayrollRepository $payrollRepo)
    {
        $this->payrollRepository = $payrollRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrolls",
     *      summary="Get a listing of the Payrolls.",
     *      tags={"Payroll"},
     *      description="Get all Payrolls",
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
     *                  @SWG\Items(ref="#/definitions/Payroll")
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
        $payrolls = $this->payrollRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PayrollResource::collection($payrolls), 'Payrolls retrieved successfully');
    }

    /**
     * @param CreatePayrollAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/payrolls",
     *      summary="Store a newly created Payroll in storage",
     *      tags={"Payroll"},
     *      description="Store Payroll",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Payroll that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Payroll")
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
     *                  ref="#/definitions/Payroll"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePayrollAPIRequest $request)
    {
        $input = $request->all();

        $payroll = $this->payrollRepository->create($input);

        return $this->sendResponse(new PayrollResource($payroll), 'Payroll saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrolls/{id}",
     *      summary="Display the specified Payroll",
     *      tags={"Payroll"},
     *      description="Get Payroll",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Payroll",
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
     *                  ref="#/definitions/Payroll"
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
        /** @var Payroll $payroll */
        $payroll = $this->payrollRepository->find($id);

        if (empty($payroll)) {
            return $this->sendError('Payroll not found');
        }

        return $this->sendResponse(new PayrollResource($payroll), 'Payroll retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePayrollAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/payrolls/{id}",
     *      summary="Update the specified Payroll in storage",
     *      tags={"Payroll"},
     *      description="Update Payroll",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Payroll",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Payroll that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Payroll")
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
     *                  ref="#/definitions/Payroll"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePayrollAPIRequest $request)
    {
        $input = $request->all();

        /** @var Payroll $payroll */
        $payroll = $this->payrollRepository->find($id);

        if (empty($payroll)) {
            return $this->sendError('Payroll not found');
        }

        $payroll = $this->payrollRepository->update($input, $id);

        return $this->sendResponse(new PayrollResource($payroll), 'Payroll updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/payrolls/{id}",
     *      summary="Remove the specified Payroll from storage",
     *      tags={"Payroll"},
     *      description="Delete Payroll",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Payroll",
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
        /** @var Payroll $payroll */
        $payroll = $this->payrollRepository->find($id);

        if (empty($payroll)) {
            return $this->sendError('Payroll not found');
        }

        $payroll->delete();

        return $this->sendSuccess('Payroll deleted successfully');
    }
}
