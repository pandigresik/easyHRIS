<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSalaryGroupAPIRequest;
use App\Http\Requests\API\Hr\UpdateSalaryGroupAPIRequest;
use App\Models\Hr\SalaryGroup;
use App\Repositories\Hr\SalaryGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SalaryGroupResource;
use Response;

/**
 * Class SalaryGroupController
 * @package App\Http\Controllers\API\Hr
 */

class SalaryGroupAPIController extends AppBaseController
{
    /** @var  SalaryGroupRepository */
    private $salaryGroupRepository;

    public function __construct(SalaryGroupRepository $salaryGroupRepo)
    {
        $this->salaryGroupRepository = $salaryGroupRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryGroups",
     *      summary="Get a listing of the SalaryGroups.",
     *      tags={"SalaryGroup"},
     *      description="Get all SalaryGroups",
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
     *                  @SWG\Items(ref="#/definitions/SalaryGroup")
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
        $salaryGroups = $this->salaryGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SalaryGroupResource::collection($salaryGroups), 'Salary Groups retrieved successfully');
    }

    /**
     * @param CreateSalaryGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/salaryGroups",
     *      summary="Store a newly created SalaryGroup in storage",
     *      tags={"SalaryGroup"},
     *      description="Store SalaryGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryGroup that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryGroup")
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
     *                  ref="#/definitions/SalaryGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSalaryGroupAPIRequest $request)
    {
        $input = $request->all();

        $salaryGroup = $this->salaryGroupRepository->create($input);

        return $this->sendResponse(new SalaryGroupResource($salaryGroup), 'Salary Group saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryGroups/{id}",
     *      summary="Display the specified SalaryGroup",
     *      tags={"SalaryGroup"},
     *      description="Get SalaryGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryGroup",
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
     *                  ref="#/definitions/SalaryGroup"
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
        /** @var SalaryGroup $salaryGroup */
        $salaryGroup = $this->salaryGroupRepository->find($id);

        if (empty($salaryGroup)) {
            return $this->sendError('Salary Group not found');
        }

        return $this->sendResponse(new SalaryGroupResource($salaryGroup), 'Salary Group retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSalaryGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/salaryGroups/{id}",
     *      summary="Update the specified SalaryGroup in storage",
     *      tags={"SalaryGroup"},
     *      description="Update SalaryGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryGroup",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryGroup that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryGroup")
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
     *                  ref="#/definitions/SalaryGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSalaryGroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var SalaryGroup $salaryGroup */
        $salaryGroup = $this->salaryGroupRepository->find($id);

        if (empty($salaryGroup)) {
            return $this->sendError('Salary Group not found');
        }

        $salaryGroup = $this->salaryGroupRepository->update($input, $id);

        return $this->sendResponse(new SalaryGroupResource($salaryGroup), 'SalaryGroup updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/salaryGroups/{id}",
     *      summary="Remove the specified SalaryGroup from storage",
     *      tags={"SalaryGroup"},
     *      description="Delete SalaryGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryGroup",
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
        /** @var SalaryGroup $salaryGroup */
        $salaryGroup = $this->salaryGroupRepository->find($id);

        if (empty($salaryGroup)) {
            return $this->sendError('Salary Group not found');
        }

        $salaryGroup->delete();

        return $this->sendSuccess('Salary Group deleted successfully');
    }
}
