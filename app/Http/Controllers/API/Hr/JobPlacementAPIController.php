<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateJobPlacementAPIRequest;
use App\Http\Requests\API\Hr\UpdateJobPlacementAPIRequest;
use App\Models\Hr\JobPlacement;
use App\Repositories\Hr\JobPlacementRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\JobPlacementResource;
use Response;

/**
 * Class JobPlacementController
 * @package App\Http\Controllers\API\Hr
 */

class JobPlacementAPIController extends AppBaseController
{
    /** @var  JobPlacementRepository */
    private $jobPlacementRepository;

    public function __construct(JobPlacementRepository $jobPlacementRepo)
    {
        $this->jobPlacementRepository = $jobPlacementRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobPlacements",
     *      summary="Get a listing of the JobPlacements.",
     *      tags={"JobPlacement"},
     *      description="Get all JobPlacements",
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
     *                  @SWG\Items(ref="#/definitions/JobPlacement")
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
        $jobPlacements = $this->jobPlacementRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(JobPlacementResource::collection($jobPlacements), 'Job Placements retrieved successfully');
    }

    /**
     * @param CreateJobPlacementAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/jobPlacements",
     *      summary="Store a newly created JobPlacement in storage",
     *      tags={"JobPlacement"},
     *      description="Store JobPlacement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobPlacement that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobPlacement")
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
     *                  ref="#/definitions/JobPlacement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobPlacementAPIRequest $request)
    {
        $input = $request->all();

        $jobPlacement = $this->jobPlacementRepository->create($input);

        return $this->sendResponse(new JobPlacementResource($jobPlacement), 'Job Placement saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobPlacements/{id}",
     *      summary="Display the specified JobPlacement",
     *      tags={"JobPlacement"},
     *      description="Get JobPlacement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobPlacement",
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
     *                  ref="#/definitions/JobPlacement"
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
        /** @var JobPlacement $jobPlacement */
        $jobPlacement = $this->jobPlacementRepository->find($id);

        if (empty($jobPlacement)) {
            return $this->sendError('Job Placement not found');
        }

        return $this->sendResponse(new JobPlacementResource($jobPlacement), 'Job Placement retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobPlacementAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/jobPlacements/{id}",
     *      summary="Update the specified JobPlacement in storage",
     *      tags={"JobPlacement"},
     *      description="Update JobPlacement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobPlacement",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobPlacement that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobPlacement")
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
     *                  ref="#/definitions/JobPlacement"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobPlacementAPIRequest $request)
    {
        $input = $request->all();

        /** @var JobPlacement $jobPlacement */
        $jobPlacement = $this->jobPlacementRepository->find($id);

        if (empty($jobPlacement)) {
            return $this->sendError('Job Placement not found');
        }

        $jobPlacement = $this->jobPlacementRepository->update($input, $id);

        return $this->sendResponse(new JobPlacementResource($jobPlacement), 'JobPlacement updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/jobPlacements/{id}",
     *      summary="Remove the specified JobPlacement from storage",
     *      tags={"JobPlacement"},
     *      description="Delete JobPlacement",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobPlacement",
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
        /** @var JobPlacement $jobPlacement */
        $jobPlacement = $this->jobPlacementRepository->find($id);

        if (empty($jobPlacement)) {
            return $this->sendError('Job Placement not found');
        }

        $jobPlacement->delete();

        return $this->sendSuccess('Job Placement deleted successfully');
    }
}
