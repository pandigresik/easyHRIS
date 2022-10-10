<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateJobTitleAPIRequest;
use App\Http\Requests\API\Hr\UpdateJobTitleAPIRequest;
use App\Models\Hr\JobTitle;
use App\Repositories\Hr\JobTitleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\JobTitleResource;
use Response;

/**
 * Class JobTitleController
 * @package App\Http\Controllers\API\Hr
 */

class JobTitleAPIController extends AppBaseController
{
    /** @var  JobTitleRepository */
    private $jobTitleRepository;

    public function __construct(JobTitleRepository $jobTitleRepo)
    {
        $this->jobTitleRepository = $jobTitleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobTitles",
     *      summary="Get a listing of the JobTitles.",
     *      tags={"JobTitle"},
     *      description="Get all JobTitles",
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
     *                  @SWG\Items(ref="#/definitions/JobTitle")
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
        $jobTitles = $this->jobTitleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(JobTitleResource::collection($jobTitles), 'Job Titles retrieved successfully');
    }

    /**
     * @param CreateJobTitleAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/jobTitles",
     *      summary="Store a newly created JobTitle in storage",
     *      tags={"JobTitle"},
     *      description="Store JobTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobTitle that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobTitle")
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
     *                  ref="#/definitions/JobTitle"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateJobTitleAPIRequest $request)
    {
        $input = $request->all();

        $jobTitle = $this->jobTitleRepository->create($input);

        return $this->sendResponse(new JobTitleResource($jobTitle), 'Job Title saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/jobTitles/{id}",
     *      summary="Display the specified JobTitle",
     *      tags={"JobTitle"},
     *      description="Get JobTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobTitle",
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
     *                  ref="#/definitions/JobTitle"
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
        /** @var JobTitle $jobTitle */
        $jobTitle = $this->jobTitleRepository->find($id);

        if (empty($jobTitle)) {
            return $this->sendError('Job Title not found');
        }

        return $this->sendResponse(new JobTitleResource($jobTitle), 'Job Title retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateJobTitleAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/jobTitles/{id}",
     *      summary="Update the specified JobTitle in storage",
     *      tags={"JobTitle"},
     *      description="Update JobTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobTitle",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="JobTitle that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/JobTitle")
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
     *                  ref="#/definitions/JobTitle"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateJobTitleAPIRequest $request)
    {
        $input = $request->all();

        /** @var JobTitle $jobTitle */
        $jobTitle = $this->jobTitleRepository->find($id);

        if (empty($jobTitle)) {
            return $this->sendError('Job Title not found');
        }

        $jobTitle = $this->jobTitleRepository->update($input, $id);

        return $this->sendResponse(new JobTitleResource($jobTitle), 'JobTitle updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/jobTitles/{id}",
     *      summary="Remove the specified JobTitle from storage",
     *      tags={"JobTitle"},
     *      description="Delete JobTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of JobTitle",
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
        /** @var JobTitle $jobTitle */
        $jobTitle = $this->jobTitleRepository->find($id);

        if (empty($jobTitle)) {
            return $this->sendError('Job Title not found');
        }

        $jobTitle->delete();

        return $this->sendSuccess('Job Title deleted successfully');
    }
}
