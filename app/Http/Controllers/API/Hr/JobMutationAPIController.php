<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateJobMutationAPIRequest;
use App\Http\Requests\API\Hr\UpdateJobMutationAPIRequest;
use App\Models\Hr\JobMutation;
use App\Repositories\Hr\JobMutationRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\JobMutationResource;
use Response;

/**
 * Class JobMutationController
 * @package App\Http\Controllers\API\Hr
 */

class JobMutationAPIController extends AppBaseController
{
    /** @var  JobMutationRepository */
    private $jobMutationRepository;

    public function __construct(JobMutationRepository $jobMutationRepo)
    {
        $this->jobMutationRepository = $jobMutationRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobMutations",
     *      summary="Get a listing of the JobMutations.",
     *      tags={"JobMutation"},
     *      description="Get all JobMutations",
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
     *                  @SWG\Items(ref="#/definitions/JobMutation")
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
        $jobMutations = $this->jobMutationRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(JobMutationResource::collection($jobMutations), 'Job Mutations retrieved successfully');
    }

    /**
     * @param CreateJobMutationAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/jobMutations",
     *      summary="Store a newly created JobMutation in storage",
     *      tags={"JobMutation"},
     *      description="Store JobMutation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobMutation that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobMutation")
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
     *                  ref="#/definitions/JobMutation"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobMutationAPIRequest $request)
    {
        $input = $request->all();

        $jobMutation = $this->jobMutationRepository->create($input);

        return $this->sendResponse(new JobMutationResource($jobMutation), 'Job Mutation saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobMutations/{id}",
     *      summary="Display the specified JobMutation",
     *      tags={"JobMutation"},
     *      description="Get JobMutation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobMutation",
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
     *                  ref="#/definitions/JobMutation"
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
        /** @var JobMutation $jobMutation */
        $jobMutation = $this->jobMutationRepository->find($id);

        if (empty($jobMutation)) {
            return $this->sendError('Job Mutation not found');
        }

        return $this->sendResponse(new JobMutationResource($jobMutation), 'Job Mutation retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobMutationAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/jobMutations/{id}",
     *      summary="Update the specified JobMutation in storage",
     *      tags={"JobMutation"},
     *      description="Update JobMutation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobMutation",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobMutation that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobMutation")
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
     *                  ref="#/definitions/JobMutation"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobMutationAPIRequest $request)
    {
        $input = $request->all();

        /** @var JobMutation $jobMutation */
        $jobMutation = $this->jobMutationRepository->find($id);

        if (empty($jobMutation)) {
            return $this->sendError('Job Mutation not found');
        }

        $jobMutation = $this->jobMutationRepository->update($input, $id);

        return $this->sendResponse(new JobMutationResource($jobMutation), 'JobMutation updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/jobMutations/{id}",
     *      summary="Remove the specified JobMutation from storage",
     *      tags={"JobMutation"},
     *      description="Delete JobMutation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobMutation",
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
        /** @var JobMutation $jobMutation */
        $jobMutation = $this->jobMutationRepository->find($id);

        if (empty($jobMutation)) {
            return $this->sendError('Job Mutation not found');
        }

        $jobMutation->delete();

        return $this->sendSuccess('Job Mutation deleted successfully');
    }
}
