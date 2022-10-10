<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateAttendanceLogfingerAPIRequest;
use App\Http\Requests\API\Hr\UpdateAttendanceLogfingerAPIRequest;
use App\Models\Hr\AttendanceLogfinger;
use App\Repositories\Hr\AttendanceLogfingerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\AttendanceLogfingerResource;
use Response;

/**
 * Class AttendanceLogfingerController
 * @package App\Http\Controllers\API\Hr
 */

class AttendanceLogfingerAPIController extends AppBaseController
{
    /** @var  AttendanceLogfingerRepository */
    private $attendanceLogfingerRepository;

    public function __construct(AttendanceLogfingerRepository $attendanceLogfingerRepo)
    {
        $this->attendanceLogfingerRepository = $attendanceLogfingerRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/attendanceLogfingers",
     *      summary="Get a listing of the AttendanceLogfingers.",
     *      tags={"AttendanceLogfinger"},
     *      description="Get all AttendanceLogfingers",
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
     *                  @SWG\Items(ref="#/definitions/AttendanceLogfinger")
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
        $attendanceLogfingers = $this->attendanceLogfingerRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(AttendanceLogfingerResource::collection($attendanceLogfingers), 'Attendance Logfingers retrieved successfully');
    }

    /**
     * @param CreateAttendanceLogfingerAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/attendanceLogfingers",
     *      summary="Store a newly created AttendanceLogfinger in storage",
     *      tags={"AttendanceLogfinger"},
     *      description="Store AttendanceLogfinger",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttendanceLogfinger that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttendanceLogfinger")
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
     *                  ref="#/definitions/AttendanceLogfinger"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateAttendanceLogfingerAPIRequest $request)
    {
        $input = $request->all();

        $attendanceLogfinger = $this->attendanceLogfingerRepository->create($input);

        return $this->sendResponse(new AttendanceLogfingerResource($attendanceLogfinger), 'Attendance Logfinger saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/attendanceLogfingers/{id}",
     *      summary="Display the specified AttendanceLogfinger",
     *      tags={"AttendanceLogfinger"},
     *      description="Get AttendanceLogfinger",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttendanceLogfinger",
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
     *                  ref="#/definitions/AttendanceLogfinger"
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
        /** @var AttendanceLogfinger $attendanceLogfinger */
        $attendanceLogfinger = $this->attendanceLogfingerRepository->find($id);

        if (empty($attendanceLogfinger)) {
            return $this->sendError('Attendance Logfinger not found');
        }

        return $this->sendResponse(new AttendanceLogfingerResource($attendanceLogfinger), 'Attendance Logfinger retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateAttendanceLogfingerAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/attendanceLogfingers/{id}",
     *      summary="Update the specified AttendanceLogfinger in storage",
     *      tags={"AttendanceLogfinger"},
     *      description="Update AttendanceLogfinger",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttendanceLogfinger",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="AttendanceLogfinger that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/AttendanceLogfinger")
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
     *                  ref="#/definitions/AttendanceLogfinger"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateAttendanceLogfingerAPIRequest $request)
    {
        $input = $request->all();

        /** @var AttendanceLogfinger $attendanceLogfinger */
        $attendanceLogfinger = $this->attendanceLogfingerRepository->find($id);

        if (empty($attendanceLogfinger)) {
            return $this->sendError('Attendance Logfinger not found');
        }

        $attendanceLogfinger = $this->attendanceLogfingerRepository->update($input, $id);

        return $this->sendResponse(new AttendanceLogfingerResource($attendanceLogfinger), 'AttendanceLogfinger updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/attendanceLogfingers/{id}",
     *      summary="Remove the specified AttendanceLogfinger from storage",
     *      tags={"AttendanceLogfinger"},
     *      description="Delete AttendanceLogfinger",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of AttendanceLogfinger",
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
        /** @var AttendanceLogfinger $attendanceLogfinger */
        $attendanceLogfinger = $this->attendanceLogfingerRepository->find($id);

        if (empty($attendanceLogfinger)) {
            return $this->sendError('Attendance Logfinger not found');
        }

        $attendanceLogfinger->delete();

        return $this->sendSuccess('Attendance Logfinger deleted successfully');
    }
}
