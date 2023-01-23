<?php

namespace App\Http\Controllers\API\Utility;

use App\Http\Requests\API\Utility\CreateFailedJobAPIRequest;
use App\Http\Requests\API\Utility\UpdateFailedJobAPIRequest;
use App\Models\Utility\FailedJob;
use App\Repositories\Utility\FailedJobRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Utility\FailedJobResource;
use Response;

/**
 * Class FailedJobController
 * @package App\Http\Controllers\API\Utility
 */

class FailedJobAPIController extends AppBaseController
{
    /** @var  FailedJobRepository */
    private $failedJobRepository;

    public function __construct(FailedJobRepository $failedJobRepo)
    {
        $this->failedJobRepository = $failedJobRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/failedJobs",
     *      summary="Get a listing of the FailedJobs.",
     *      tags={"FailedJob"},
     *      description="Get all FailedJobs",
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
     *                  @SWG\Items(ref="#/definitions/FailedJob")
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
        $failedJobs = $this->failedJobRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(FailedJobResource::collection($failedJobs), 'Failed Jobs retrieved successfully');
    }

    /**
     * @param CreateFailedJobAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/failedJobs",
     *      summary="Store a newly created FailedJob in storage",
     *      tags={"FailedJob"},
     *      description="Store FailedJob",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="FailedJob that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/FailedJob")
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
     *                  ref="#/definitions/FailedJob"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateFailedJobAPIRequest $request)
    {
        $input = $request->all();

        $failedJob = $this->failedJobRepository->create($input);

        return $this->sendResponse(new FailedJobResource($failedJob), 'Failed Job saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/failedJobs/{id}",
     *      summary="Display the specified FailedJob",
     *      tags={"FailedJob"},
     *      description="Get FailedJob",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FailedJob",
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
     *                  ref="#/definitions/FailedJob"
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
        /** @var FailedJob $failedJob */
        $failedJob = $this->failedJobRepository->find($id);

        if (empty($failedJob)) {
            return $this->sendError('Failed Job not found');
        }

        return $this->sendResponse(new FailedJobResource($failedJob), 'Failed Job retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateFailedJobAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/failedJobs/{id}",
     *      summary="Update the specified FailedJob in storage",
     *      tags={"FailedJob"},
     *      description="Update FailedJob",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FailedJob",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="FailedJob that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/FailedJob")
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
     *                  ref="#/definitions/FailedJob"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateFailedJobAPIRequest $request)
    {
        $input = $request->all();

        /** @var FailedJob $failedJob */
        $failedJob = $this->failedJobRepository->find($id);

        if (empty($failedJob)) {
            return $this->sendError('Failed Job not found');
        }

        $failedJob = $this->failedJobRepository->update($input, $id);

        return $this->sendResponse(new FailedJobResource($failedJob), 'FailedJob updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/failedJobs/{id}",
     *      summary="Remove the specified FailedJob from storage",
     *      tags={"FailedJob"},
     *      description="Delete FailedJob",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of FailedJob",
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
        /** @var FailedJob $failedJob */
        $failedJob = $this->failedJobRepository->find($id);

        if (empty($failedJob)) {
            return $this->sendError('Failed Job not found');
        }

        $failedJob->delete();

        return $this->sendSuccess('Failed Job deleted successfully');
    }
}
