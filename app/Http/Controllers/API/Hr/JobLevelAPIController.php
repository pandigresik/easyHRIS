<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateJobLevelAPIRequest;
use App\Http\Requests\API\Hr\UpdateJobLevelAPIRequest;
use App\Models\Hr\JobLevel;
use App\Repositories\Hr\JobLevelRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\JobLevelResource;
use Response;

/**
 * Class JobLevelController
 * @package App\Http\Controllers\API\Hr
 */

class JobLevelAPIController extends AppBaseController
{
    /** @var  JobLevelRepository */
    private $jobLevelRepository;

    public function __construct(JobLevelRepository $jobLevelRepo)
    {
        $this->jobLevelRepository = $jobLevelRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobLevels",
     *      summary="Get a listing of the JobLevels.",
     *      tags={"JobLevel"},
     *      description="Get all JobLevels",
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
     *                  @SWG\Items(ref="#/definitions/JobLevel")
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
        $jobLevels = $this->jobLevelRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(JobLevelResource::collection($jobLevels), 'Job Levels retrieved successfully');
    }

    /**
     * @param CreateJobLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/jobLevels",
     *      summary="Store a newly created JobLevel in storage",
     *      tags={"JobLevel"},
     *      description="Store JobLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobLevel that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobLevel")
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
     *                  ref="#/definitions/JobLevel"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobLevelAPIRequest $request)
    {
        $input = $request->all();

        $jobLevel = $this->jobLevelRepository->create($input);

        return $this->sendResponse(new JobLevelResource($jobLevel), 'Job Level saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobLevels/{id}",
     *      summary="Display the specified JobLevel",
     *      tags={"JobLevel"},
     *      description="Get JobLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobLevel",
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
     *                  ref="#/definitions/JobLevel"
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
        /** @var JobLevel $jobLevel */
        $jobLevel = $this->jobLevelRepository->find($id);

        if (empty($jobLevel)) {
            return $this->sendError('Job Level not found');
        }

        return $this->sendResponse(new JobLevelResource($jobLevel), 'Job Level retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobLevelAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/jobLevels/{id}",
     *      summary="Update the specified JobLevel in storage",
     *      tags={"JobLevel"},
     *      description="Update JobLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobLevel",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobLevel that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobLevel")
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
     *                  ref="#/definitions/JobLevel"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobLevelAPIRequest $request)
    {
        $input = $request->all();

        /** @var JobLevel $jobLevel */
        $jobLevel = $this->jobLevelRepository->find($id);

        if (empty($jobLevel)) {
            return $this->sendError('Job Level not found');
        }

        $jobLevel = $this->jobLevelRepository->update($input, $id);

        return $this->sendResponse(new JobLevelResource($jobLevel), 'JobLevel updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/jobLevels/{id}",
     *      summary="Remove the specified JobLevel from storage",
     *      tags={"JobLevel"},
     *      description="Delete JobLevel",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobLevel",
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
        /** @var JobLevel $jobLevel */
        $jobLevel = $this->jobLevelRepository->find($id);

        if (empty($jobLevel)) {
            return $this->sendError('Job Level not found');
        }

        $jobLevel->delete();

        return $this->sendSuccess('Job Level deleted successfully');
    }
}
