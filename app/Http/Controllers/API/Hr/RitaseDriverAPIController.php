<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateRitaseDriverAPIRequest;
use App\Http\Requests\API\Hr\UpdateRitaseDriverAPIRequest;
use App\Models\Hr\RitaseDriver;
use App\Repositories\Hr\RitaseDriverRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\RitaseDriverResource;
use Response;

/**
 * Class RitaseDriverController
 * @package App\Http\Controllers\API\Hr
 */

class RitaseDriverAPIController extends AppBaseController
{
    /** @var  RitaseDriverRepository */
    private $ritaseDriverRepository;

    public function __construct(RitaseDriverRepository $ritaseDriverRepo)
    {
        $this->ritaseDriverRepository = $ritaseDriverRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/ritaseDrivers",
     *      summary="Get a listing of the RitaseDrivers.",
     *      tags={"RitaseDriver"},
     *      description="Get all RitaseDrivers",
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
     *                  @SWG\Items(ref="#/definitions/RitaseDriver")
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
        $ritaseDrivers = $this->ritaseDriverRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(RitaseDriverResource::collection($ritaseDrivers), 'Ritase Drivers retrieved successfully');
    }

    /**
     * @param CreateRitaseDriverAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/ritaseDrivers",
     *      summary="Store a newly created RitaseDriver in storage",
     *      tags={"RitaseDriver"},
     *      description="Store RitaseDriver",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RitaseDriver that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RitaseDriver")
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
     *                  ref="#/definitions/RitaseDriver"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRitaseDriverAPIRequest $request)
    {
        $input = $request->all();

        $ritaseDriver = $this->ritaseDriverRepository->create($input);

        return $this->sendResponse(new RitaseDriverResource($ritaseDriver), 'Ritase Driver saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/ritaseDrivers/{id}",
     *      summary="Display the specified RitaseDriver",
     *      tags={"RitaseDriver"},
     *      description="Get RitaseDriver",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RitaseDriver",
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
     *                  ref="#/definitions/RitaseDriver"
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
        /** @var RitaseDriver $ritaseDriver */
        $ritaseDriver = $this->ritaseDriverRepository->find($id);

        if (empty($ritaseDriver)) {
            return $this->sendError('Ritase Driver not found');
        }

        return $this->sendResponse(new RitaseDriverResource($ritaseDriver), 'Ritase Driver retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRitaseDriverAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/ritaseDrivers/{id}",
     *      summary="Update the specified RitaseDriver in storage",
     *      tags={"RitaseDriver"},
     *      description="Update RitaseDriver",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RitaseDriver",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RitaseDriver that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RitaseDriver")
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
     *                  ref="#/definitions/RitaseDriver"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRitaseDriverAPIRequest $request)
    {
        $input = $request->all();

        /** @var RitaseDriver $ritaseDriver */
        $ritaseDriver = $this->ritaseDriverRepository->find($id);

        if (empty($ritaseDriver)) {
            return $this->sendError('Ritase Driver not found');
        }

        $ritaseDriver = $this->ritaseDriverRepository->update($input, $id);

        return $this->sendResponse(new RitaseDriverResource($ritaseDriver), 'RitaseDriver updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/ritaseDrivers/{id}",
     *      summary="Remove the specified RitaseDriver from storage",
     *      tags={"RitaseDriver"},
     *      description="Delete RitaseDriver",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RitaseDriver",
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
        /** @var RitaseDriver $ritaseDriver */
        $ritaseDriver = $this->ritaseDriverRepository->find($id);

        if (empty($ritaseDriver)) {
            return $this->sendError('Ritase Driver not found');
        }

        $ritaseDriver->delete();

        return $this->sendSuccess('Ritase Driver deleted successfully');
    }
}
