<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateShiftmentGroupDetailAPIRequest;
use App\Http\Requests\API\Hr\UpdateShiftmentGroupDetailAPIRequest;
use App\Models\Hr\ShiftmentGroupDetail;
use App\Repositories\Hr\ShiftmentGroupDetailRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\ShiftmentGroupDetailResource;
use Response;

/**
 * Class ShiftmentGroupDetailController
 * @package App\Http\Controllers\API\Hr
 */

class ShiftmentGroupDetailAPIController extends AppBaseController
{
    /** @var  ShiftmentGroupDetailRepository */
    private $shiftmentGroupDetailRepository;

    public function __construct(ShiftmentGroupDetailRepository $shiftmentGroupDetailRepo)
    {
        $this->shiftmentGroupDetailRepository = $shiftmentGroupDetailRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftmentGroupDetails",
     *      summary="Get a listing of the ShiftmentGroupDetails.",
     *      tags={"ShiftmentGroupDetail"},
     *      description="Get all ShiftmentGroupDetails",
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
     *                  @SWG\Items(ref="#/definitions/ShiftmentGroupDetail")
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
        $shiftmentGroupDetails = $this->shiftmentGroupDetailRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ShiftmentGroupDetailResource::collection($shiftmentGroupDetails), 'Shiftment Group Details retrieved successfully');
    }

    /**
     * @param CreateShiftmentGroupDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/shiftmentGroupDetails",
     *      summary="Store a newly created ShiftmentGroupDetail in storage",
     *      tags={"ShiftmentGroupDetail"},
     *      description="Store ShiftmentGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ShiftmentGroupDetail that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ShiftmentGroupDetail")
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
     *                  ref="#/definitions/ShiftmentGroupDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateShiftmentGroupDetailAPIRequest $request)
    {
        $input = $request->all();

        $shiftmentGroupDetail = $this->shiftmentGroupDetailRepository->create($input);

        return $this->sendResponse(new ShiftmentGroupDetailResource($shiftmentGroupDetail), 'Shiftment Group Detail saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftmentGroupDetails/{id}",
     *      summary="Display the specified ShiftmentGroupDetail",
     *      tags={"ShiftmentGroupDetail"},
     *      description="Get ShiftmentGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentGroupDetail",
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
     *                  ref="#/definitions/ShiftmentGroupDetail"
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
        /** @var ShiftmentGroupDetail $shiftmentGroupDetail */
        $shiftmentGroupDetail = $this->shiftmentGroupDetailRepository->find($id);

        if (empty($shiftmentGroupDetail)) {
            return $this->sendError('Shiftment Group Detail not found');
        }

        return $this->sendResponse(new ShiftmentGroupDetailResource($shiftmentGroupDetail), 'Shiftment Group Detail retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateShiftmentGroupDetailAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/shiftmentGroupDetails/{id}",
     *      summary="Update the specified ShiftmentGroupDetail in storage",
     *      tags={"ShiftmentGroupDetail"},
     *      description="Update ShiftmentGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentGroupDetail",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ShiftmentGroupDetail that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ShiftmentGroupDetail")
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
     *                  ref="#/definitions/ShiftmentGroupDetail"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateShiftmentGroupDetailAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShiftmentGroupDetail $shiftmentGroupDetail */
        $shiftmentGroupDetail = $this->shiftmentGroupDetailRepository->find($id);

        if (empty($shiftmentGroupDetail)) {
            return $this->sendError('Shiftment Group Detail not found');
        }

        $shiftmentGroupDetail = $this->shiftmentGroupDetailRepository->update($input, $id);

        return $this->sendResponse(new ShiftmentGroupDetailResource($shiftmentGroupDetail), 'ShiftmentGroupDetail updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/shiftmentGroupDetails/{id}",
     *      summary="Remove the specified ShiftmentGroupDetail from storage",
     *      tags={"ShiftmentGroupDetail"},
     *      description="Delete ShiftmentGroupDetail",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentGroupDetail",
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
        /** @var ShiftmentGroupDetail $shiftmentGroupDetail */
        $shiftmentGroupDetail = $this->shiftmentGroupDetailRepository->find($id);

        if (empty($shiftmentGroupDetail)) {
            return $this->sendError('Shiftment Group Detail not found');
        }

        $shiftmentGroupDetail->delete();

        return $this->sendSuccess('Shiftment Group Detail deleted successfully');
    }
}
