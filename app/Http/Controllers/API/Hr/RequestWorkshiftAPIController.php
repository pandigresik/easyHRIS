<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateRequestWorkshiftAPIRequest;
use App\Http\Requests\API\Hr\UpdateRequestWorkshiftAPIRequest;
use App\Models\Hr\RequestWorkshift;
use App\Repositories\Hr\RequestWorkshiftRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\RequestWorkshiftResource;
use Response;

/**
 * Class RequestWorkshiftController
 * @package App\Http\Controllers\API\Hr
 */

class RequestWorkshiftAPIController extends AppBaseController
{
    /** @var  RequestWorkshiftRepository */
    private $requestWorkshiftRepository;

    public function __construct(RequestWorkshiftRepository $requestWorkshiftRepo)
    {
        $this->requestWorkshiftRepository = $requestWorkshiftRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/requestWorkshifts",
     *      summary="Get a listing of the RequestWorkshifts.",
     *      tags={"RequestWorkshift"},
     *      description="Get all RequestWorkshifts",
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
     *                  @SWG\Items(ref="#/definitions/RequestWorkshift")
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
        $requestWorkshifts = $this->requestWorkshiftRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(RequestWorkshiftResource::collection($requestWorkshifts), 'Request Workshifts retrieved successfully');
    }

    /**
     * @param CreateRequestWorkshiftAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/requestWorkshifts",
     *      summary="Store a newly created RequestWorkshift in storage",
     *      tags={"RequestWorkshift"},
     *      description="Store RequestWorkshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RequestWorkshift that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RequestWorkshift")
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
     *                  ref="#/definitions/RequestWorkshift"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateRequestWorkshiftAPIRequest $request)
    {
        $input = $request->all();

        $requestWorkshift = $this->requestWorkshiftRepository->create($input);

        return $this->sendResponse(new RequestWorkshiftResource($requestWorkshift), 'Request Workshift saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/requestWorkshifts/{id}",
     *      summary="Display the specified RequestWorkshift",
     *      tags={"RequestWorkshift"},
     *      description="Get RequestWorkshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RequestWorkshift",
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
     *                  ref="#/definitions/RequestWorkshift"
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
        /** @var RequestWorkshift $requestWorkshift */
        $requestWorkshift = $this->requestWorkshiftRepository->find($id);

        if (empty($requestWorkshift)) {
            return $this->sendError('Request Workshift not found');
        }

        return $this->sendResponse(new RequestWorkshiftResource($requestWorkshift), 'Request Workshift retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateRequestWorkshiftAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/requestWorkshifts/{id}",
     *      summary="Update the specified RequestWorkshift in storage",
     *      tags={"RequestWorkshift"},
     *      description="Update RequestWorkshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RequestWorkshift",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="RequestWorkshift that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/RequestWorkshift")
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
     *                  ref="#/definitions/RequestWorkshift"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateRequestWorkshiftAPIRequest $request)
    {
        $input = $request->all();

        /** @var RequestWorkshift $requestWorkshift */
        $requestWorkshift = $this->requestWorkshiftRepository->find($id);

        if (empty($requestWorkshift)) {
            return $this->sendError('Request Workshift not found');
        }

        $requestWorkshift = $this->requestWorkshiftRepository->update($input, $id);

        return $this->sendResponse(new RequestWorkshiftResource($requestWorkshift), 'RequestWorkshift updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/requestWorkshifts/{id}",
     *      summary="Remove the specified RequestWorkshift from storage",
     *      tags={"RequestWorkshift"},
     *      description="Delete RequestWorkshift",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of RequestWorkshift",
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
        /** @var RequestWorkshift $requestWorkshift */
        $requestWorkshift = $this->requestWorkshiftRepository->find($id);

        if (empty($requestWorkshift)) {
            return $this->sendError('Request Workshift not found');
        }

        $requestWorkshift->delete();

        return $this->sendSuccess('Request Workshift deleted successfully');
    }
}
