<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateAbsentReasonAPIRequest;
use App\Http\Requests\API\Hr\UpdateAbsentReasonAPIRequest;
use App\Models\Hr\AbsentReason;
use App\Repositories\Hr\AbsentReasonRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\AbsentReasonResource;
use Response;

/**
 * Class AbsentReasonController
 * @package App\Http\Controllers\API\Hr
 */

class AbsentReasonAPIController extends AppBaseController
{
    /** @var  AbsentReasonRepository */
    private $absentReasonRepository;

    public function __construct(AbsentReasonRepository $absentReasonRepo)
    {
        $this->absentReasonRepository = $absentReasonRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/absentReasons",
     *      summary="Get a listing of the AbsentReasons.",
     *      tags={"AbsentReason"},
     *      description="Get all AbsentReasons",
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
     *                  @SWG\Items(ref="#/definitions/AbsentReason")
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
        $absentReasons = $this->absentReasonRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AbsentReasonResource::collection($absentReasons), 'Absent Reasons retrieved successfully');
    }

    /**
     * @param CreateAbsentReasonAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/absentReasons",
     *      summary="Store a newly created AbsentReason in storage",
     *      tags={"AbsentReason"},
     *      description="Store AbsentReason",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AbsentReason that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AbsentReason")
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
     *                  ref="#/definitions/AbsentReason"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAbsentReasonAPIRequest $request)
    {
        $input = $request->all();

        $absentReason = $this->absentReasonRepository->create($input);

        return $this->sendResponse(new AbsentReasonResource($absentReason), 'Absent Reason saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/absentReasons/{id}",
     *      summary="Display the specified AbsentReason",
     *      tags={"AbsentReason"},
     *      description="Get AbsentReason",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AbsentReason",
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
     *                  ref="#/definitions/AbsentReason"
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
        /** @var AbsentReason $absentReason */
        $absentReason = $this->absentReasonRepository->find($id);

        if (empty($absentReason)) {
            return $this->sendError('Absent Reason not found');
        }

        return $this->sendResponse(new AbsentReasonResource($absentReason), 'Absent Reason retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAbsentReasonAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/absentReasons/{id}",
     *      summary="Update the specified AbsentReason in storage",
     *      tags={"AbsentReason"},
     *      description="Update AbsentReason",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AbsentReason",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AbsentReason that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AbsentReason")
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
     *                  ref="#/definitions/AbsentReason"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAbsentReasonAPIRequest $request)
    {
        $input = $request->all();

        /** @var AbsentReason $absentReason */
        $absentReason = $this->absentReasonRepository->find($id);

        if (empty($absentReason)) {
            return $this->sendError('Absent Reason not found');
        }

        $absentReason = $this->absentReasonRepository->update($input, $id);

        return $this->sendResponse(new AbsentReasonResource($absentReason), 'AbsentReason updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/absentReasons/{id}",
     *      summary="Remove the specified AbsentReason from storage",
     *      tags={"AbsentReason"},
     *      description="Delete AbsentReason",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AbsentReason",
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
        /** @var AbsentReason $absentReason */
        $absentReason = $this->absentReasonRepository->find($id);

        if (empty($absentReason)) {
            return $this->sendError('Absent Reason not found');
        }

        $absentReason->delete();

        return $this->sendSuccess('Absent Reason deleted successfully');
    }
}
