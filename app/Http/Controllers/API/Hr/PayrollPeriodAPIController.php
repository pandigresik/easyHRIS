<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreatePayrollPeriodAPIRequest;
use App\Http\Requests\API\Hr\UpdatePayrollPeriodAPIRequest;
use App\Models\Hr\PayrollPeriod;
use App\Repositories\Hr\PayrollPeriodRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\PayrollPeriodResource;
use Response;

/**
 * Class PayrollPeriodController
 * @package App\Http\Controllers\API\Hr
 */

class PayrollPeriodAPIController extends AppBaseController
{
    /** @var  PayrollPeriodRepository */
    private $payrollPeriodRepository;

    public function __construct(PayrollPeriodRepository $payrollPeriodRepo)
    {
        $this->payrollPeriodRepository = $payrollPeriodRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrollPeriods",
     *      summary="Get a listing of the PayrollPeriods.",
     *      tags={"PayrollPeriod"},
     *      description="Get all PayrollPeriods",
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
     *                  @SWG\Items(ref="#/definitions/PayrollPeriod")
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
        $payrollPeriods = $this->payrollPeriodRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(PayrollPeriodResource::collection($payrollPeriods), 'Payroll Periods retrieved successfully');
    }

    /**
     * @param CreatePayrollPeriodAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/payrollPeriods",
     *      summary="Store a newly created PayrollPeriod in storage",
     *      tags={"PayrollPeriod"},
     *      description="Store PayrollPeriod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PayrollPeriod that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PayrollPeriod")
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
     *                  ref="#/definitions/PayrollPeriod"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreatePayrollPeriodAPIRequest $request)
    {
        $input = $request->all();

        $payrollPeriod = $this->payrollPeriodRepository->create($input);

        return $this->sendResponse(new PayrollPeriodResource($payrollPeriod), 'Payroll Period saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/payrollPeriods/{id}",
     *      summary="Display the specified PayrollPeriod",
     *      tags={"PayrollPeriod"},
     *      description="Get PayrollPeriod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollPeriod",
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
     *                  ref="#/definitions/PayrollPeriod"
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
        /** @var PayrollPeriod $payrollPeriod */
        $payrollPeriod = $this->payrollPeriodRepository->find($id);

        if (empty($payrollPeriod)) {
            return $this->sendError('Payroll Period not found');
        }

        return $this->sendResponse(new PayrollPeriodResource($payrollPeriod), 'Payroll Period retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdatePayrollPeriodAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/payrollPeriods/{id}",
     *      summary="Update the specified PayrollPeriod in storage",
     *      tags={"PayrollPeriod"},
     *      description="Update PayrollPeriod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollPeriod",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="PayrollPeriod that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PayrollPeriod")
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
     *                  ref="#/definitions/PayrollPeriod"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdatePayrollPeriodAPIRequest $request)
    {
        $input = $request->all();

        /** @var PayrollPeriod $payrollPeriod */
        $payrollPeriod = $this->payrollPeriodRepository->find($id);

        if (empty($payrollPeriod)) {
            return $this->sendError('Payroll Period not found');
        }

        $payrollPeriod = $this->payrollPeriodRepository->update($input, $id);

        return $this->sendResponse(new PayrollPeriodResource($payrollPeriod), 'PayrollPeriod updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/payrollPeriods/{id}",
     *      summary="Remove the specified PayrollPeriod from storage",
     *      tags={"PayrollPeriod"},
     *      description="Delete PayrollPeriod",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of PayrollPeriod",
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
        /** @var PayrollPeriod $payrollPeriod */
        $payrollPeriod = $this->payrollPeriodRepository->find($id);

        if (empty($payrollPeriod)) {
            return $this->sendError('Payroll Period not found');
        }

        $payrollPeriod->delete();

        return $this->sendSuccess('Payroll Period deleted successfully');
    }
}
