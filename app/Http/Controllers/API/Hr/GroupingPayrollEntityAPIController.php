<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateGroupingPayrollEntityAPIRequest;
use App\Http\Requests\API\Hr\UpdateGroupingPayrollEntityAPIRequest;
use App\Models\Hr\GroupingPayrollEntity;
use App\Repositories\Hr\GroupingPayrollEntityRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\GroupingPayrollEntityResource;
use Response;

/**
 * Class GroupingPayrollEntityController
 * @package App\Http\Controllers\API\Hr
 */

class GroupingPayrollEntityAPIController extends AppBaseController
{
    /** @var  GroupingPayrollEntityRepository */
    private $groupingPayrollEntityRepository;

    public function __construct(GroupingPayrollEntityRepository $groupingPayrollEntityRepo)
    {
        $this->groupingPayrollEntityRepository = $groupingPayrollEntityRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/groupingPayrollEntities",
     *      summary="Get a listing of the GroupingPayrollEntities.",
     *      tags={"GroupingPayrollEntity"},
     *      description="Get all GroupingPayrollEntities",
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
     *                  @SWG\Items(ref="#/definitions/GroupingPayrollEntity")
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
        $groupingPayrollEntities = $this->groupingPayrollEntityRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(GroupingPayrollEntityResource::collection($groupingPayrollEntities), 'Grouping Payroll Entities retrieved successfully');
    }

    /**
     * @param CreateGroupingPayrollEntityAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/groupingPayrollEntities",
     *      summary="Store a newly created GroupingPayrollEntity in storage",
     *      tags={"GroupingPayrollEntity"},
     *      description="Store GroupingPayrollEntity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="GroupingPayrollEntity that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/GroupingPayrollEntity")
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
     *                  ref="#/definitions/GroupingPayrollEntity"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGroupingPayrollEntityAPIRequest $request)
    {
        $input = $request->all();

        $groupingPayrollEntity = $this->groupingPayrollEntityRepository->create($input);

        return $this->sendResponse(new GroupingPayrollEntityResource($groupingPayrollEntity), 'Grouping Payroll Entity saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/groupingPayrollEntities/{id}",
     *      summary="Display the specified GroupingPayrollEntity",
     *      tags={"GroupingPayrollEntity"},
     *      description="Get GroupingPayrollEntity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GroupingPayrollEntity",
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
     *                  ref="#/definitions/GroupingPayrollEntity"
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
        /** @var GroupingPayrollEntity $groupingPayrollEntity */
        $groupingPayrollEntity = $this->groupingPayrollEntityRepository->find($id);

        if (empty($groupingPayrollEntity)) {
            return $this->sendError('Grouping Payroll Entity not found');
        }

        return $this->sendResponse(new GroupingPayrollEntityResource($groupingPayrollEntity), 'Grouping Payroll Entity retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateGroupingPayrollEntityAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/groupingPayrollEntities/{id}",
     *      summary="Update the specified GroupingPayrollEntity in storage",
     *      tags={"GroupingPayrollEntity"},
     *      description="Update GroupingPayrollEntity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GroupingPayrollEntity",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="GroupingPayrollEntity that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/GroupingPayrollEntity")
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
     *                  ref="#/definitions/GroupingPayrollEntity"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGroupingPayrollEntityAPIRequest $request)
    {
        $input = $request->all();

        /** @var GroupingPayrollEntity $groupingPayrollEntity */
        $groupingPayrollEntity = $this->groupingPayrollEntityRepository->find($id);

        if (empty($groupingPayrollEntity)) {
            return $this->sendError('Grouping Payroll Entity not found');
        }

        $groupingPayrollEntity = $this->groupingPayrollEntityRepository->update($input, $id);

        return $this->sendResponse(new GroupingPayrollEntityResource($groupingPayrollEntity), 'GroupingPayrollEntity updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/groupingPayrollEntities/{id}",
     *      summary="Remove the specified GroupingPayrollEntity from storage",
     *      tags={"GroupingPayrollEntity"},
     *      description="Delete GroupingPayrollEntity",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GroupingPayrollEntity",
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
        /** @var GroupingPayrollEntity $groupingPayrollEntity */
        $groupingPayrollEntity = $this->groupingPayrollEntityRepository->find($id);

        if (empty($groupingPayrollEntity)) {
            return $this->sendError('Grouping Payroll Entity not found');
        }

        $groupingPayrollEntity->delete();

        return $this->sendSuccess('Grouping Payroll Entity deleted successfully');
    }
}
