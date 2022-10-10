<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSalaryBenefitHistoryAPIRequest;
use App\Http\Requests\API\Hr\UpdateSalaryBenefitHistoryAPIRequest;
use App\Models\Hr\SalaryBenefitHistory;
use App\Repositories\Hr\SalaryBenefitHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SalaryBenefitHistoryResource;
use Response;

/**
 * Class SalaryBenefitHistoryController
 * @package App\Http\Controllers\API\Hr
 */

class SalaryBenefitHistoryAPIController extends AppBaseController
{
    /** @var  SalaryBenefitHistoryRepository */
    private $salaryBenefitHistoryRepository;

    public function __construct(SalaryBenefitHistoryRepository $salaryBenefitHistoryRepo)
    {
        $this->salaryBenefitHistoryRepository = $salaryBenefitHistoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryBenefitHistories",
     *      summary="Get a listing of the SalaryBenefitHistories.",
     *      tags={"SalaryBenefitHistory"},
     *      description="Get all SalaryBenefitHistories",
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
     *                  @SWG\Items(ref="#/definitions/SalaryBenefitHistory")
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
        $salaryBenefitHistories = $this->salaryBenefitHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SalaryBenefitHistoryResource::collection($salaryBenefitHistories), 'Salary Benefit Histories retrieved successfully');
    }

    /**
     * @param CreateSalaryBenefitHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/salaryBenefitHistories",
     *      summary="Store a newly created SalaryBenefitHistory in storage",
     *      tags={"SalaryBenefitHistory"},
     *      description="Store SalaryBenefitHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryBenefitHistory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryBenefitHistory")
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
     *                  ref="#/definitions/SalaryBenefitHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSalaryBenefitHistoryAPIRequest $request)
    {
        $input = $request->all();

        $salaryBenefitHistory = $this->salaryBenefitHistoryRepository->create($input);

        return $this->sendResponse(new SalaryBenefitHistoryResource($salaryBenefitHistory), 'Salary Benefit History saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryBenefitHistories/{id}",
     *      summary="Display the specified SalaryBenefitHistory",
     *      tags={"SalaryBenefitHistory"},
     *      description="Get SalaryBenefitHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryBenefitHistory",
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
     *                  ref="#/definitions/SalaryBenefitHistory"
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
        /** @var SalaryBenefitHistory $salaryBenefitHistory */
        $salaryBenefitHistory = $this->salaryBenefitHistoryRepository->find($id);

        if (empty($salaryBenefitHistory)) {
            return $this->sendError('Salary Benefit History not found');
        }

        return $this->sendResponse(new SalaryBenefitHistoryResource($salaryBenefitHistory), 'Salary Benefit History retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSalaryBenefitHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/salaryBenefitHistories/{id}",
     *      summary="Update the specified SalaryBenefitHistory in storage",
     *      tags={"SalaryBenefitHistory"},
     *      description="Update SalaryBenefitHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryBenefitHistory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryBenefitHistory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryBenefitHistory")
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
     *                  ref="#/definitions/SalaryBenefitHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSalaryBenefitHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var SalaryBenefitHistory $salaryBenefitHistory */
        $salaryBenefitHistory = $this->salaryBenefitHistoryRepository->find($id);

        if (empty($salaryBenefitHistory)) {
            return $this->sendError('Salary Benefit History not found');
        }

        $salaryBenefitHistory = $this->salaryBenefitHistoryRepository->update($input, $id);

        return $this->sendResponse(new SalaryBenefitHistoryResource($salaryBenefitHistory), 'SalaryBenefitHistory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/salaryBenefitHistories/{id}",
     *      summary="Remove the specified SalaryBenefitHistory from storage",
     *      tags={"SalaryBenefitHistory"},
     *      description="Delete SalaryBenefitHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryBenefitHistory",
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
        /** @var SalaryBenefitHistory $salaryBenefitHistory */
        $salaryBenefitHistory = $this->salaryBenefitHistoryRepository->find($id);

        if (empty($salaryBenefitHistory)) {
            return $this->sendError('Salary Benefit History not found');
        }

        $salaryBenefitHistory->delete();

        return $this->sendSuccess('Salary Benefit History deleted successfully');
    }
}
