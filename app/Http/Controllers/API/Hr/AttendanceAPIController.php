<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateAttendanceAPIRequest;
use App\Http\Requests\API\Hr\UpdateAttendanceAPIRequest;
use App\Models\Hr\Attendance;
use App\Repositories\Hr\AttendanceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\AttendanceResource;
use Response;

/**
 * Class AttendanceController
 * @package App\Http\Controllers\API\Hr
 */

class AttendanceAPIController extends AppBaseController
{
    /** @var  AttendanceRepository */
    private $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepo)
    {
        $this->attendanceRepository = $attendanceRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/attendances",
     *      summary="Get a listing of the Attendances.",
     *      tags={"Attendance"},
     *      description="Get all Attendances",
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
     *                  @SWG\Items(ref="#/definitions/Attendance")
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
        $attendances = $this->attendanceRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AttendanceResource::collection($attendances), 'Attendances retrieved successfully');
    }

    /**
     * @param CreateAttendanceAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/attendances",
     *      summary="Store a newly created Attendance in storage",
     *      tags={"Attendance"},
     *      description="Store Attendance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Attendance that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Attendance")
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
     *                  ref="#/definitions/Attendance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAttendanceAPIRequest $request)
    {
        $input = $request->all();

        $attendance = $this->attendanceRepository->create($input);

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/attendances/{id}",
     *      summary="Display the specified Attendance",
     *      tags={"Attendance"},
     *      description="Get Attendance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Attendance",
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
     *                  ref="#/definitions/Attendance"
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
        /** @var Attendance $attendance */
        $attendance = $this->attendanceRepository->find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAttendanceAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/attendances/{id}",
     *      summary="Update the specified Attendance in storage",
     *      tags={"Attendance"},
     *      description="Update Attendance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Attendance",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Attendance that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Attendance")
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
     *                  ref="#/definitions/Attendance"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAttendanceAPIRequest $request)
    {
        $input = $request->all();

        /** @var Attendance $attendance */
        $attendance = $this->attendanceRepository->find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        $attendance = $this->attendanceRepository->update($input, $id);

        return $this->sendResponse(new AttendanceResource($attendance), 'Attendance updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/attendances/{id}",
     *      summary="Remove the specified Attendance from storage",
     *      tags={"Attendance"},
     *      description="Delete Attendance",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Attendance",
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
        /** @var Attendance $attendance */
        $attendance = $this->attendanceRepository->find($id);

        if (empty($attendance)) {
            return $this->sendError('Attendance not found');
        }

        $attendance->delete();

        return $this->sendSuccess('Attendance deleted successfully');
    }
}
