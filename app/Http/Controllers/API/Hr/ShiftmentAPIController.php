<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateShiftmentAPIRequest;
use App\Http\Requests\API\Hr\UpdateShiftmentAPIRequest;
use App\Models\Hr\Shiftment;
use App\Repositories\Hr\ShiftmentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\ShiftmentResource;
use Response;

/**
 * Class ShiftmentController
 * @package App\Http\Controllers\API\Hr
 */

class ShiftmentAPIController extends AppBaseController
{
    /** @var  ShiftmentRepository */
    private $shiftmentRepository;

    public function __construct(ShiftmentRepository $shiftmentRepo)
    {
        $this->shiftmentRepository = $shiftmentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftments",
     *      summary="Get a listing of the Shiftments.",
     *      tags={"Shiftment"},
     *      description="Get all Shiftments",
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
     *                  @SWG\Items(ref="#/definitions/Shiftment")
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
        $shiftments = $this->shiftmentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ShiftmentResource::collection($shiftments), 'Shiftments retrieved successfully');
    }

    /**
     * @param CreateShiftmentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/shiftments",
     *      summary="Store a newly created Shiftment in storage",
     *      tags={"Shiftment"},
     *      description="Store Shiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Shiftment that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Shiftment")
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
     *                  ref="#/definitions/Shiftment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateShiftmentAPIRequest $request)
    {
        $input = $request->all();

        $shiftment = $this->shiftmentRepository->create($input);

        return $this->sendResponse(new ShiftmentResource($shiftment), 'Shiftment saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/shiftments/{id}",
     *      summary="Display the specified Shiftment",
     *      tags={"Shiftment"},
     *      description="Get Shiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Shiftment",
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
     *                  ref="#/definitions/Shiftment"
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
        /** @var Shiftment $shiftment */
        $shiftment = $this->shiftmentRepository->find($id);

        if (empty($shiftment)) {
            return $this->sendError('Shiftment not found');
        }

        return $this->sendResponse(new ShiftmentResource($shiftment), 'Shiftment retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateShiftmentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/shiftments/{id}",
     *      summary="Update the specified Shiftment in storage",
     *      tags={"Shiftment"},
     *      description="Update Shiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Shiftment",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Shiftment that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Shiftment")
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
     *                  ref="#/definitions/Shiftment"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateShiftmentAPIRequest $request)
    {
        $input = $request->all();

        /** @var Shiftment $shiftment */
        $shiftment = $this->shiftmentRepository->find($id);

        if (empty($shiftment)) {
            return $this->sendError('Shiftment not found');
        }

        $shiftment = $this->shiftmentRepository->update($input, $id);

        return $this->sendResponse(new ShiftmentResource($shiftment), 'Shiftment updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/shiftments/{id}",
     *      summary="Remove the specified Shiftment from storage",
     *      tags={"Shiftment"},
     *      description="Delete Shiftment",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Shiftment",
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
        /** @var Shiftment $shiftment */
        $shiftment = $this->shiftmentRepository->find($id);

        if (empty($shiftment)) {
            return $this->sendError('Shiftment not found');
        }

        $shiftment->delete();

        return $this->sendSuccess('Shiftment deleted successfully');
    }
}
