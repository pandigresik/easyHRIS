<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSalaryAllowanceAPIRequest;
use App\Http\Requests\API\Hr\UpdateSalaryAllowanceAPIRequest;
use App\Models\Hr\SalaryAllowance;
use App\Repositories\Hr\SalaryAllowanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SalaryAllowanceResource;
use Response;

/**
 * Class SalaryAllowanceController
 * @package App\Http\Controllers\API\Hr
 */

class SalaryAllowanceAPIController extends AppBaseController
{
    /** @var  SalaryAllowanceRepository */
    private $salaryAllowanceRepository;

    public function __construct(SalaryAllowanceRepository $salaryAllowanceRepo)
    {
        $this->salaryAllowanceRepository = $salaryAllowanceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryAllowances",
     *      summary="Get a listing of the SalaryAllowances.",
     *      tags={"SalaryAllowance"},
     *      description="Get all SalaryAllowances",
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
     *                  @SWG\Items(ref="#/definitions/SalaryAllowance")
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
        $salaryAllowances = $this->salaryAllowanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SalaryAllowanceResource::collection($salaryAllowances), 'Salary Allowances retrieved successfully');
    }

    /**
     * @param CreateSalaryAllowanceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/salaryAllowances",
     *      summary="Store a newly created SalaryAllowance in storage",
     *      tags={"SalaryAllowance"},
     *      description="Store SalaryAllowance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryAllowance that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryAllowance")
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
     *                  ref="#/definitions/SalaryAllowance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSalaryAllowanceAPIRequest $request)
    {
        $input = $request->all();

        $salaryAllowance = $this->salaryAllowanceRepository->create($input);

        return $this->sendResponse(new SalaryAllowanceResource($salaryAllowance), 'Salary Allowance saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryAllowances/{id}",
     *      summary="Display the specified SalaryAllowance",
     *      tags={"SalaryAllowance"},
     *      description="Get SalaryAllowance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryAllowance",
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
     *                  ref="#/definitions/SalaryAllowance"
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
        /** @var SalaryAllowance $salaryAllowance */
        $salaryAllowance = $this->salaryAllowanceRepository->find($id);

        if (empty($salaryAllowance)) {
            return $this->sendError('Salary Allowance not found');
        }

        return $this->sendResponse(new SalaryAllowanceResource($salaryAllowance), 'Salary Allowance retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSalaryAllowanceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/salaryAllowances/{id}",
     *      summary="Update the specified SalaryAllowance in storage",
     *      tags={"SalaryAllowance"},
     *      description="Update SalaryAllowance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryAllowance",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryAllowance that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryAllowance")
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
     *                  ref="#/definitions/SalaryAllowance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSalaryAllowanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var SalaryAllowance $salaryAllowance */
        $salaryAllowance = $this->salaryAllowanceRepository->find($id);

        if (empty($salaryAllowance)) {
            return $this->sendError('Salary Allowance not found');
        }

        $salaryAllowance = $this->salaryAllowanceRepository->update($input, $id);

        return $this->sendResponse(new SalaryAllowanceResource($salaryAllowance), 'SalaryAllowance updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/salaryAllowances/{id}",
     *      summary="Remove the specified SalaryAllowance from storage",
     *      tags={"SalaryAllowance"},
     *      description="Delete SalaryAllowance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryAllowance",
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
        /** @var SalaryAllowance $salaryAllowance */
        $salaryAllowance = $this->salaryAllowanceRepository->find($id);

        if (empty($salaryAllowance)) {
            return $this->sendError('Salary Allowance not found');
        }

        $salaryAllowance->delete();

        return $this->sendSuccess('Salary Allowance deleted successfully');
    }
}
