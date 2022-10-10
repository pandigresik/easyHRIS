<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateShiftmentGroupAPIRequest;
use App\Http\Requests\API\Hr\UpdateShiftmentGroupAPIRequest;
use App\Models\Hr\ShiftmentGroup;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\ShiftmentGroupResource;
use Response;

/**
 * Class ShiftmentGroupController
 * @package App\Http\Controllers\API\Hr
 */

class ShiftmentGroupAPIController extends AppBaseController
{
    /** @var  ShiftmentGroupRepository */
    private $shiftmentGroupRepository;

    public function __construct(ShiftmentGroupRepository $shiftmentGroupRepo)
    {
        $this->shiftmentGroupRepository = $shiftmentGroupRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftmentGroups",
     *      summary="Get a listing of the ShiftmentGroups.",
     *      tags={"ShiftmentGroup"},
     *      description="Get all ShiftmentGroups",
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
     *                  @SWG\Items(ref="#/definitions/ShiftmentGroup")
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
        $shiftmentGroups = $this->shiftmentGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ShiftmentGroupResource::collection($shiftmentGroups), 'Shiftment Groups retrieved successfully');
    }

    /**
     * @param CreateShiftmentGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/shiftmentGroups",
     *      summary="Store a newly created ShiftmentGroup in storage",
     *      tags={"ShiftmentGroup"},
     *      description="Store ShiftmentGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ShiftmentGroup that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ShiftmentGroup")
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
     *                  ref="#/definitions/ShiftmentGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateShiftmentGroupAPIRequest $request)
    {
        $input = $request->all();

        $shiftmentGroup = $this->shiftmentGroupRepository->create($input);

        return $this->sendResponse(new ShiftmentGroupResource($shiftmentGroup), 'Shiftment Group saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftmentGroups/{id}",
     *      summary="Display the specified ShiftmentGroup",
     *      tags={"ShiftmentGroup"},
     *      description="Get ShiftmentGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentGroup",
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
     *                  ref="#/definitions/ShiftmentGroup"
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
        /** @var ShiftmentGroup $shiftmentGroup */
        $shiftmentGroup = $this->shiftmentGroupRepository->find($id);

        if (empty($shiftmentGroup)) {
            return $this->sendError('Shiftment Group not found');
        }

        return $this->sendResponse(new ShiftmentGroupResource($shiftmentGroup), 'Shiftment Group retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateShiftmentGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/shiftmentGroups/{id}",
     *      summary="Update the specified ShiftmentGroup in storage",
     *      tags={"ShiftmentGroup"},
     *      description="Update ShiftmentGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentGroup",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="ShiftmentGroup that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/ShiftmentGroup")
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
     *                  ref="#/definitions/ShiftmentGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateShiftmentGroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var ShiftmentGroup $shiftmentGroup */
        $shiftmentGroup = $this->shiftmentGroupRepository->find($id);

        if (empty($shiftmentGroup)) {
            return $this->sendError('Shiftment Group not found');
        }

        $shiftmentGroup = $this->shiftmentGroupRepository->update($input, $id);

        return $this->sendResponse(new ShiftmentGroupResource($shiftmentGroup), 'ShiftmentGroup updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/shiftmentGroups/{id}",
     *      summary="Remove the specified ShiftmentGroup from storage",
     *      tags={"ShiftmentGroup"},
     *      description="Delete ShiftmentGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of ShiftmentGroup",
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
        /** @var ShiftmentGroup $shiftmentGroup */
        $shiftmentGroup = $this->shiftmentGroupRepository->find($id);

        if (empty($shiftmentGroup)) {
            return $this->sendError('Shiftment Group not found');
        }

        $shiftmentGroup->delete();

        return $this->sendSuccess('Shiftment Group deleted successfully');
    }
}
