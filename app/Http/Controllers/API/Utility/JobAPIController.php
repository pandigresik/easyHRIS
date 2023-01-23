<?php

namespace App\Http\Controllers\API\Utility;

use App\Http\Requests\API\Utility\CreateJobAPIRequest;
use App\Http\Requests\API\Utility\UpdateJobAPIRequest;
use App\Models\Utility\Job;
use App\Repositories\Utility\JobRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Utility\JobResource;
use Response;

/**
 * Class JobController
 * @package App\Http\Controllers\API\Utility
 */

class JobAPIController extends AppBaseController
{
    /** @var  JobRepository */
    private $jobRepository;

    public function __construct(JobRepository $jobRepo)
    {
        $this->jobRepository = $jobRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobs",
     *      summary="Get a listing of the Jobs.",
     *      tags={"Job"},
     *      description="Get all Jobs",
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
     *                  @SWG\Items(ref="#/definitions/Job")
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
        $jobs = $this->jobRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(JobResource::collection($jobs), 'Jobs retrieved successfully');
    }

    /**
     * @param CreateJobAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/jobs",
     *      summary="Store a newly created Job in storage",
     *      tags={"Job"},
     *      description="Store Job",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Job that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Job")
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
     *                  ref="#/definitions/Job"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobAPIRequest $request)
    {
        $input = $request->all();

        $job = $this->jobRepository->create($input);

        return $this->sendResponse(new JobResource($job), 'Job saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobs/{id}",
     *      summary="Display the specified Job",
     *      tags={"Job"},
     *      description="Get Job",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Job",
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
     *                  ref="#/definitions/Job"
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
        /** @var Job $job */
        $job = $this->jobRepository->find($id);

        if (empty($job)) {
            return $this->sendError('Job not found');
        }

        return $this->sendResponse(new JobResource($job), 'Job retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/jobs/{id}",
     *      summary="Update the specified Job in storage",
     *      tags={"Job"},
     *      description="Update Job",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Job",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Job that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Job")
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
     *                  ref="#/definitions/Job"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobAPIRequest $request)
    {
        $input = $request->all();

        /** @var Job $job */
        $job = $this->jobRepository->find($id);

        if (empty($job)) {
            return $this->sendError('Job not found');
        }

        $job = $this->jobRepository->update($input, $id);

        return $this->sendResponse(new JobResource($job), 'Job updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/jobs/{id}",
     *      summary="Remove the specified Job from storage",
     *      tags={"Job"},
     *      description="Delete Job",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Job",
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
        /** @var Job $job */
        $job = $this->jobRepository->find($id);

        if (empty($job)) {
            return $this->sendError('Job not found');
        }

        $job->delete();

        return $this->sendSuccess('Job deleted successfully');
    }
}
