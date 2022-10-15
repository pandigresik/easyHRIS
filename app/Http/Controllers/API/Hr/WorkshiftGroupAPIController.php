<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateWorkshiftGroupAPIRequest;
use App\Http\Requests\API\Hr\UpdateWorkshiftGroupAPIRequest;
use App\Models\Hr\WorkshiftGroup;
use App\Repositories\Hr\WorkshiftGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\WorkshiftGroupResource;
use Response;

/**
 * Class WorkshiftGroupController
 * @package App\Http\Controllers\API\Hr
 */

class WorkshiftGroupAPIController extends AppBaseController
{
    /** @var  WorkshiftGroupRepository */
    private $workshiftGroupRepository;

    public function __construct(WorkshiftGroupRepository $workshiftGroupRepo)
    {
        $this->workshiftGroupRepository = $workshiftGroupRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/workshiftGroups",
     *      summary="Get a listing of the WorkshiftGroups.",
     *      tags={"WorkshiftGroup"},
     *      description="Get all WorkshiftGroups",
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
     *                  @SWG\Items(ref="#/definitions/WorkshiftGroup")
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
        $workshiftGroups = $this->workshiftGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(WorkshiftGroupResource::collection($workshiftGroups), 'Workshift Groups retrieved successfully');
    }

    /**
     * @param CreateWorkshiftGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/workshiftGroups",
     *      summary="Store a newly created WorkshiftGroup in storage",
     *      tags={"WorkshiftGroup"},
     *      description="Store WorkshiftGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="WorkshiftGroup that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/WorkshiftGroup")
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
     *                  ref="#/definitions/WorkshiftGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateWorkshiftGroupAPIRequest $request)
    {
        $input = $request->all();

        $workshiftGroup = $this->workshiftGroupRepository->create($input);

        return $this->sendResponse(new WorkshiftGroupResource($workshiftGroup), 'Workshift Group saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/workshiftGroups/{id}",
     *      summary="Display the specified WorkshiftGroup",
     *      tags={"WorkshiftGroup"},
     *      description="Get WorkshiftGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of WorkshiftGroup",
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
     *                  ref="#/definitions/WorkshiftGroup"
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
        /** @var WorkshiftGroup $workshiftGroup */
        $workshiftGroup = $this->workshiftGroupRepository->find($id);

        if (empty($workshiftGroup)) {
            return $this->sendError('Workshift Group not found');
        }

        return $this->sendResponse(new WorkshiftGroupResource($workshiftGroup), 'Workshift Group retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateWorkshiftGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/workshiftGroups/{id}",
     *      summary="Update the specified WorkshiftGroup in storage",
     *      tags={"WorkshiftGroup"},
     *      description="Update WorkshiftGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of WorkshiftGroup",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="WorkshiftGroup that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/WorkshiftGroup")
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
     *                  ref="#/definitions/WorkshiftGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateWorkshiftGroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var WorkshiftGroup $workshiftGroup */
        $workshiftGroup = $this->workshiftGroupRepository->find($id);

        if (empty($workshiftGroup)) {
            return $this->sendError('Workshift Group not found');
        }

        $workshiftGroup = $this->workshiftGroupRepository->update($input, $id);

        return $this->sendResponse(new WorkshiftGroupResource($workshiftGroup), 'WorkshiftGroup updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/workshiftGroups/{id}",
     *      summary="Remove the specified WorkshiftGroup from storage",
     *      tags={"WorkshiftGroup"},
     *      description="Delete WorkshiftGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of WorkshiftGroup",
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
        /** @var WorkshiftGroup $workshiftGroup */
        $workshiftGroup = $this->workshiftGroupRepository->find($id);

        if (empty($workshiftGroup)) {
            return $this->sendError('Workshift Group not found');
        }

        $workshiftGroup->delete();

        return $this->sendSuccess('Workshift Group deleted successfully');
    }
}
