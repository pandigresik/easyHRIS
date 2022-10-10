<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateAttendanceSummaryAPIRequest;
use App\Http\Requests\API\Hr\UpdateAttendanceSummaryAPIRequest;
use App\Models\Hr\AttendanceSummary;
use App\Repositories\Hr\AttendanceSummaryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\AttendanceSummaryResource;
use Response;

/**
 * Class AttendanceSummaryController
 * @package App\Http\Controllers\API\Hr
 */

class AttendanceSummaryAPIController extends AppBaseController
{
    /** @var  AttendanceSummaryRepository */
    private $attendanceSummaryRepository;

    public function __construct(AttendanceSummaryRepository $attendanceSummaryRepo)
    {
        $this->attendanceSummaryRepository = $attendanceSummaryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/attendanceSummaries",
     *      summary="Get a listing of the AttendanceSummaries.",
     *      tags={"AttendanceSummary"},
     *      description="Get all AttendanceSummaries",
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
     *                  @SWG\Items(ref="#/definitions/AttendanceSummary")
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
        $attendanceSummaries = $this->attendanceSummaryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AttendanceSummaryResource::collection($attendanceSummaries), 'Attendance Summaries retrieved successfully');
    }

    /**
     * @param CreateAttendanceSummaryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/attendanceSummaries",
     *      summary="Store a newly created AttendanceSummary in storage",
     *      tags={"AttendanceSummary"},
     *      description="Store AttendanceSummary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttendanceSummary that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttendanceSummary")
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
     *                  ref="#/definitions/AttendanceSummary"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAttendanceSummaryAPIRequest $request)
    {
        $input = $request->all();

        $attendanceSummary = $this->attendanceSummaryRepository->create($input);

        return $this->sendResponse(new AttendanceSummaryResource($attendanceSummary), 'Attendance Summary saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/attendanceSummaries/{id}",
     *      summary="Display the specified AttendanceSummary",
     *      tags={"AttendanceSummary"},
     *      description="Get AttendanceSummary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttendanceSummary",
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
     *                  ref="#/definitions/AttendanceSummary"
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
        /** @var AttendanceSummary $attendanceSummary */
        $attendanceSummary = $this->attendanceSummaryRepository->find($id);

        if (empty($attendanceSummary)) {
            return $this->sendError('Attendance Summary not found');
        }

        return $this->sendResponse(new AttendanceSummaryResource($attendanceSummary), 'Attendance Summary retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAttendanceSummaryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/attendanceSummaries/{id}",
     *      summary="Update the specified AttendanceSummary in storage",
     *      tags={"AttendanceSummary"},
     *      description="Update AttendanceSummary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttendanceSummary",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttendanceSummary that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttendanceSummary")
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
     *                  ref="#/definitions/AttendanceSummary"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAttendanceSummaryAPIRequest $request)
    {
        $input = $request->all();

        /** @var AttendanceSummary $attendanceSummary */
        $attendanceSummary = $this->attendanceSummaryRepository->find($id);

        if (empty($attendanceSummary)) {
            return $this->sendError('Attendance Summary not found');
        }

        $attendanceSummary = $this->attendanceSummaryRepository->update($input, $id);

        return $this->sendResponse(new AttendanceSummaryResource($attendanceSummary), 'AttendanceSummary updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/attendanceSummaries/{id}",
     *      summary="Remove the specified AttendanceSummary from storage",
     *      tags={"AttendanceSummary"},
     *      description="Delete AttendanceSummary",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttendanceSummary",
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
        /** @var AttendanceSummary $attendanceSummary */
        $attendanceSummary = $this->attendanceSummaryRepository->find($id);

        if (empty($attendanceSummary)) {
            return $this->sendError('Attendance Summary not found');
        }

        $attendanceSummary->delete();

        return $this->sendSuccess('Attendance Summary deleted successfully');
    }
}
