<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateShiftmentScheduleAPIRequest;
use App\Http\Requests\API\Hr\UpdateShiftmentScheduleAPIRequest;
use App\Models\Hr\ShiftmentSchedule;
use App\Repositories\Hr\ShiftmentScheduleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\ShiftmentScheduleResource;
use Response;

/**
 * Class ShiftmentScheduleController
 * @package App\Http\Controllers\API\Hr
 */

class ShiftmentScheduleAPIController extends AppBaseController
{
    /** @var  ShiftmentScheduleRepository */
    private $shiftmentScheduleRepository;

    public function __construct(ShiftmentScheduleRepository $shiftmentScheduleRepo)
    {
        $this->shiftmentScheduleRepository = $shiftmentScheduleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftmentSchedules",
     *      summary="Get a listing of the ShiftmentSchedules.",
     *      tags={"ShiftmentSchedule"},
     *      description="Get all ShiftmentSchedules",
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
     *                  @SWG\Items(ref="#/definitions/ShiftmentSchedule")
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
        $shiftmentSchedules = $this->shiftmentScheduleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ShiftmentScheduleResource::collection($shiftmentSchedules), 'Shiftment Schedules retrieved successfully');
    }

    /**
     * @param CreateShiftmentScheduleAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/shiftmentSchedules",
     *      summary="Store a newly created ShiftmentSchedule in storage",
     *      tags={"ShiftmentSchedule"},
     *      description="Store ShiftmentSchedule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ShiftmentSchedule that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ShiftmentSchedule")
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
     *                  ref="#/definitions/ShiftmentSchedule"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateShiftmentScheduleAPIRequest $request)
    {
        $input = $request->all();

        $shiftmentSchedule = $this->shiftmentScheduleRepository->create($input);

        return $this->sendResponse(new ShiftmentScheduleResource($shiftmentSchedule), 'Shiftment Schedule saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftmentSchedules/{id}",
     *      summary="Display the specified ShiftmentSchedule",
     *      tags={"ShiftmentSchedule"},
     *      description="Get ShiftmentSchedule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentSchedule",
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
     *                  ref="#/definitions/ShiftmentSchedule"
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
        /** @var ShiftmentSchedule $shiftmentSchedule */
        $shiftmentSchedule = $this->shiftmentScheduleRepository->find($id);

        if (empty($shiftmentSchedule)) {
            return $this->sendError('Shiftment Schedule not found');
        }

        return $this->sendResponse(new ShiftmentScheduleResource($shiftmentSchedule), 'Shiftment Schedule retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateShiftmentScheduleAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/shiftmentSchedules/{id}",
     *      summary="Update the specified ShiftmentSchedule in storage",
     *      tags={"ShiftmentSchedule"},
     *      description="Update ShiftmentSchedule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentSchedule",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ShiftmentSchedule that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ShiftmentSchedule")
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
     *                  ref="#/definitions/ShiftmentSchedule"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateShiftmentScheduleAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShiftmentSchedule $shiftmentSchedule */
        $shiftmentSchedule = $this->shiftmentScheduleRepository->find($id);

        if (empty($shiftmentSchedule)) {
            return $this->sendError('Shiftment Schedule not found');
        }

        $shiftmentSchedule = $this->shiftmentScheduleRepository->update($input, $id);

        return $this->sendResponse(new ShiftmentScheduleResource($shiftmentSchedule), 'ShiftmentSchedule updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/shiftmentSchedules/{id}",
     *      summary="Remove the specified ShiftmentSchedule from storage",
     *      tags={"ShiftmentSchedule"},
     *      description="Delete ShiftmentSchedule",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentSchedule",
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
        /** @var ShiftmentSchedule $shiftmentSchedule */
        $shiftmentSchedule = $this->shiftmentScheduleRepository->find($id);

        if (empty($shiftmentSchedule)) {
            return $this->sendError('Shiftment Schedule not found');
        }

        $shiftmentSchedule->delete();

        return $this->sendSuccess('Shiftment Schedule deleted successfully');
    }
}
