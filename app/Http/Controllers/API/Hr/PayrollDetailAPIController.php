<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreatePayrollDetailAPIRequest;
use App\Http\Requests\API\Hr\UpdatePayrollDetailAPIRequest;
use App\Models\Hr\PayrollDetail;
use App\Repositories\Hr\PayrollDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\PayrollDetailResource;
use Response;

/**
 * Class PayrollDetailController
 * @package App\Http\Controllers\API\Hr
 */

class PayrollDetailAPIController extends AppBaseController
{
    /** @var  PayrollDetailRepository */
    private $payrollDetailRepository;

    public function __construct(PayrollDetailRepository $payrollDetailRepo)
    {
        $this->payrollDetailRepository = $payrollDetailRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrollDetails",
     *      summary="Get a listing of the PayrollDetails.",
     *      tags={"PayrollDetail"},
     *      description="Get all PayrollDetails",
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
     *                  @SWG\Items(ref="#/definitions/PayrollDetail")
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
        $payrollDetails = $this->payrollDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PayrollDetailResource::collection($payrollDetails), 'Payroll Details retrieved successfully');
    }

    /**
     * @param CreatePayrollDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/payrollDetails",
     *      summary="Store a newly created PayrollDetail in storage",
     *      tags={"PayrollDetail"},
     *      description="Store PayrollDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PayrollDetail that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PayrollDetail")
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
     *                  ref="#/definitions/PayrollDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePayrollDetailAPIRequest $request)
    {
        $input = $request->all();

        $payrollDetail = $this->payrollDetailRepository->create($input);

        return $this->sendResponse(new PayrollDetailResource($payrollDetail), 'Payroll Detail saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrollDetails/{id}",
     *      summary="Display the specified PayrollDetail",
     *      tags={"PayrollDetail"},
     *      description="Get PayrollDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollDetail",
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
     *                  ref="#/definitions/PayrollDetail"
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
        /** @var PayrollDetail $payrollDetail */
        $payrollDetail = $this->payrollDetailRepository->find($id);

        if (empty($payrollDetail)) {
            return $this->sendError('Payroll Detail not found');
        }

        return $this->sendResponse(new PayrollDetailResource($payrollDetail), 'Payroll Detail retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePayrollDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/payrollDetails/{id}",
     *      summary="Update the specified PayrollDetail in storage",
     *      tags={"PayrollDetail"},
     *      description="Update PayrollDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollDetail",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PayrollDetail that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PayrollDetail")
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
     *                  ref="#/definitions/PayrollDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePayrollDetailAPIRequest $request)
    {
        $input = $request->all();

        /** @var PayrollDetail $payrollDetail */
        $payrollDetail = $this->payrollDetailRepository->find($id);

        if (empty($payrollDetail)) {
            return $this->sendError('Payroll Detail not found');
        }

        $payrollDetail = $this->payrollDetailRepository->update($input, $id);

        return $this->sendResponse(new PayrollDetailResource($payrollDetail), 'PayrollDetail updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/payrollDetails/{id}",
     *      summary="Remove the specified PayrollDetail from storage",
     *      tags={"PayrollDetail"},
     *      description="Delete PayrollDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollDetail",
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
        /** @var PayrollDetail $payrollDetail */
        $payrollDetail = $this->payrollDetailRepository->find($id);

        if (empty($payrollDetail)) {
            return $this->sendError('Payroll Detail not found');
        }

        $payrollDetail->delete();

        return $this->sendSuccess('Payroll Detail deleted successfully');
    }
}
