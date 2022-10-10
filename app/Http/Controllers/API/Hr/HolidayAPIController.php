<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateHolidayAPIRequest;
use App\Http\Requests\API\Hr\UpdateHolidayAPIRequest;
use App\Models\Hr\Holiday;
use App\Repositories\Hr\HolidayRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\HolidayResource;
use Response;

/**
 * Class HolidayController
 * @package App\Http\Controllers\API\Hr
 */

class HolidayAPIController extends AppBaseController
{
    /** @var  HolidayRepository */
    private $holidayRepository;

    public function __construct(HolidayRepository $holidayRepo)
    {
        $this->holidayRepository = $holidayRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/holidays",
     *      summary="Get a listing of the Holidays.",
     *      tags={"Holiday"},
     *      description="Get all Holidays",
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
     *                  @SWG\Items(ref="#/definitions/Holiday")
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
        $holidays = $this->holidayRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(HolidayResource::collection($holidays), 'Holidays retrieved successfully');
    }

    /**
     * @param CreateHolidayAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/holidays",
     *      summary="Store a newly created Holiday in storage",
     *      tags={"Holiday"},
     *      description="Store Holiday",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Holiday that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Holiday")
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
     *                  ref="#/definitions/Holiday"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHolidayAPIRequest $request)
    {
        $input = $request->all();

        $holiday = $this->holidayRepository->create($input);

        return $this->sendResponse(new HolidayResource($holiday), 'Holiday saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/holidays/{id}",
     *      summary="Display the specified Holiday",
     *      tags={"Holiday"},
     *      description="Get Holiday",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Holiday",
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
     *                  ref="#/definitions/Holiday"
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
        /** @var Holiday $holiday */
        $holiday = $this->holidayRepository->find($id);

        if (empty($holiday)) {
            return $this->sendError('Holiday not found');
        }

        return $this->sendResponse(new HolidayResource($holiday), 'Holiday retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateHolidayAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/holidays/{id}",
     *      summary="Update the specified Holiday in storage",
     *      tags={"Holiday"},
     *      description="Update Holiday",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Holiday",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Holiday that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Holiday")
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
     *                  ref="#/definitions/Holiday"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHolidayAPIRequest $request)
    {
        $input = $request->all();

        /** @var Holiday $holiday */
        $holiday = $this->holidayRepository->find($id);

        if (empty($holiday)) {
            return $this->sendError('Holiday not found');
        }

        $holiday = $this->holidayRepository->update($input, $id);

        return $this->sendResponse(new HolidayResource($holiday), 'Holiday updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/holidays/{id}",
     *      summary="Remove the specified Holiday from storage",
     *      tags={"Holiday"},
     *      description="Delete Holiday",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Holiday",
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
        /** @var Holiday $holiday */
        $holiday = $this->holidayRepository->find($id);

        if (empty($holiday)) {
            return $this->sendError('Holiday not found');
        }

        $holiday->delete();

        return $this->sendSuccess('Holiday deleted successfully');
    }
}
