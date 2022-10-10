<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateWorkshiftAPIRequest;
use App\Http\Requests\API\Hr\UpdateWorkshiftAPIRequest;
use App\Models\Hr\Workshift;
use App\Repositories\Hr\WorkshiftRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\WorkshiftResource;
use Response;

/**
 * Class WorkshiftController
 * @package App\Http\Controllers\API\Hr
 */

class WorkshiftAPIController extends AppBaseController
{
    /** @var  WorkshiftRepository */
    private $workshiftRepository;

    public function __construct(WorkshiftRepository $workshiftRepo)
    {
        $this->workshiftRepository = $workshiftRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/workshifts",
     *      summary="Get a listing of the Workshifts.",
     *      tags={"Workshift"},
     *      description="Get all Workshifts",
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
     *                  @SWG\Items(ref="#/definitions/Workshift")
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
        $workshifts = $this->workshiftRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(WorkshiftResource::collection($workshifts), 'Workshifts retrieved successfully');
    }

    /**
     * @param CreateWorkshiftAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/workshifts",
     *      summary="Store a newly created Workshift in storage",
     *      tags={"Workshift"},
     *      description="Store Workshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Workshift that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Workshift")
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
     *                  ref="#/definitions/Workshift"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateWorkshiftAPIRequest $request)
    {
        $input = $request->all();

        $workshift = $this->workshiftRepository->create($input);

        return $this->sendResponse(new WorkshiftResource($workshift), 'Workshift saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/workshifts/{id}",
     *      summary="Display the specified Workshift",
     *      tags={"Workshift"},
     *      description="Get Workshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Workshift",
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
     *                  ref="#/definitions/Workshift"
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
        /** @var Workshift $workshift */
        $workshift = $this->workshiftRepository->find($id);

        if (empty($workshift)) {
            return $this->sendError('Workshift not found');
        }

        return $this->sendResponse(new WorkshiftResource($workshift), 'Workshift retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateWorkshiftAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/workshifts/{id}",
     *      summary="Update the specified Workshift in storage",
     *      tags={"Workshift"},
     *      description="Update Workshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Workshift",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Workshift that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Workshift")
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
     *                  ref="#/definitions/Workshift"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateWorkshiftAPIRequest $request)
    {
        $input = $request->all();

        /** @var Workshift $workshift */
        $workshift = $this->workshiftRepository->find($id);

        if (empty($workshift)) {
            return $this->sendError('Workshift not found');
        }

        $workshift = $this->workshiftRepository->update($input, $id);

        return $this->sendResponse(new WorkshiftResource($workshift), 'Workshift updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/workshifts/{id}",
     *      summary="Remove the specified Workshift from storage",
     *      tags={"Workshift"},
     *      description="Delete Workshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Workshift",
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
        /** @var Workshift $workshift */
        $workshift = $this->workshiftRepository->find($id);

        if (empty($workshift)) {
            return $this->sendError('Workshift not found');
        }

        $workshift->delete();

        return $this->sendSuccess('Workshift deleted successfully');
    }
}
