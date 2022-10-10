<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSalaryGroupDetailAPIRequest;
use App\Http\Requests\API\Hr\UpdateSalaryGroupDetailAPIRequest;
use App\Models\Hr\SalaryGroupDetail;
use App\Repositories\Hr\SalaryGroupDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SalaryGroupDetailResource;
use Response;

/**
 * Class SalaryGroupDetailController
 * @package App\Http\Controllers\API\Hr
 */

class SalaryGroupDetailAPIController extends AppBaseController
{
    /** @var  SalaryGroupDetailRepository */
    private $salaryGroupDetailRepository;

    public function __construct(SalaryGroupDetailRepository $salaryGroupDetailRepo)
    {
        $this->salaryGroupDetailRepository = $salaryGroupDetailRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryGroupDetails",
     *      summary="Get a listing of the SalaryGroupDetails.",
     *      tags={"SalaryGroupDetail"},
     *      description="Get all SalaryGroupDetails",
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
     *                  @SWG\Items(ref="#/definitions/SalaryGroupDetail")
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
        $salaryGroupDetails = $this->salaryGroupDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SalaryGroupDetailResource::collection($salaryGroupDetails), 'Salary Group Details retrieved successfully');
    }

    /**
     * @param CreateSalaryGroupDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/salaryGroupDetails",
     *      summary="Store a newly created SalaryGroupDetail in storage",
     *      tags={"SalaryGroupDetail"},
     *      description="Store SalaryGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryGroupDetail that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryGroupDetail")
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
     *                  ref="#/definitions/SalaryGroupDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSalaryGroupDetailAPIRequest $request)
    {
        $input = $request->all();

        $salaryGroupDetail = $this->salaryGroupDetailRepository->create($input);

        return $this->sendResponse(new SalaryGroupDetailResource($salaryGroupDetail), 'Salary Group Detail saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryGroupDetails/{id}",
     *      summary="Display the specified SalaryGroupDetail",
     *      tags={"SalaryGroupDetail"},
     *      description="Get SalaryGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryGroupDetail",
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
     *                  ref="#/definitions/SalaryGroupDetail"
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
        /** @var SalaryGroupDetail $salaryGroupDetail */
        $salaryGroupDetail = $this->salaryGroupDetailRepository->find($id);

        if (empty($salaryGroupDetail)) {
            return $this->sendError('Salary Group Detail not found');
        }

        return $this->sendResponse(new SalaryGroupDetailResource($salaryGroupDetail), 'Salary Group Detail retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSalaryGroupDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/salaryGroupDetails/{id}",
     *      summary="Update the specified SalaryGroupDetail in storage",
     *      tags={"SalaryGroupDetail"},
     *      description="Update SalaryGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryGroupDetail",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryGroupDetail that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryGroupDetail")
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
     *                  ref="#/definitions/SalaryGroupDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSalaryGroupDetailAPIRequest $request)
    {
        $input = $request->all();

        /** @var SalaryGroupDetail $salaryGroupDetail */
        $salaryGroupDetail = $this->salaryGroupDetailRepository->find($id);

        if (empty($salaryGroupDetail)) {
            return $this->sendError('Salary Group Detail not found');
        }

        $salaryGroupDetail = $this->salaryGroupDetailRepository->update($input, $id);

        return $this->sendResponse(new SalaryGroupDetailResource($salaryGroupDetail), 'SalaryGroupDetail updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/salaryGroupDetails/{id}",
     *      summary="Remove the specified SalaryGroupDetail from storage",
     *      tags={"SalaryGroupDetail"},
     *      description="Delete SalaryGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryGroupDetail",
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
        /** @var SalaryGroupDetail $salaryGroupDetail */
        $salaryGroupDetail = $this->salaryGroupDetailRepository->find($id);

        if (empty($salaryGroupDetail)) {
            return $this->sendError('Salary Group Detail not found');
        }

        $salaryGroupDetail->delete();

        return $this->sendSuccess('Salary Group Detail deleted successfully');
    }
}
