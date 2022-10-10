<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateCareerHistoryAPIRequest;
use App\Http\Requests\API\Hr\UpdateCareerHistoryAPIRequest;
use App\Models\Hr\CareerHistory;
use App\Repositories\Hr\CareerHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\CareerHistoryResource;
use Response;

/**
 * Class CareerHistoryController
 * @package App\Http\Controllers\API\Hr
 */

class CareerHistoryAPIController extends AppBaseController
{
    /** @var  CareerHistoryRepository */
    private $careerHistoryRepository;

    public function __construct(CareerHistoryRepository $careerHistoryRepo)
    {
        $this->careerHistoryRepository = $careerHistoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/careerHistories",
     *      summary="Get a listing of the CareerHistories.",
     *      tags={"CareerHistory"},
     *      description="Get all CareerHistories",
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
     *                  @SWG\Items(ref="#/definitions/CareerHistory")
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
        $careerHistories = $this->careerHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(CareerHistoryResource::collection($careerHistories), 'Career Histories retrieved successfully');
    }

    /**
     * @param CreateCareerHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/careerHistories",
     *      summary="Store a newly created CareerHistory in storage",
     *      tags={"CareerHistory"},
     *      description="Store CareerHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CareerHistory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CareerHistory")
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
     *                  ref="#/definitions/CareerHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateCareerHistoryAPIRequest $request)
    {
        $input = $request->all();

        $careerHistory = $this->careerHistoryRepository->create($input);

        return $this->sendResponse(new CareerHistoryResource($careerHistory), 'Career History saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/careerHistories/{id}",
     *      summary="Display the specified CareerHistory",
     *      tags={"CareerHistory"},
     *      description="Get CareerHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CareerHistory",
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
     *                  ref="#/definitions/CareerHistory"
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
        /** @var CareerHistory $careerHistory */
        $careerHistory = $this->careerHistoryRepository->find($id);

        if (empty($careerHistory)) {
            return $this->sendError('Career History not found');
        }

        return $this->sendResponse(new CareerHistoryResource($careerHistory), 'Career History retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateCareerHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/careerHistories/{id}",
     *      summary="Update the specified CareerHistory in storage",
     *      tags={"CareerHistory"},
     *      description="Update CareerHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CareerHistory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="CareerHistory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/CareerHistory")
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
     *                  ref="#/definitions/CareerHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateCareerHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var CareerHistory $careerHistory */
        $careerHistory = $this->careerHistoryRepository->find($id);

        if (empty($careerHistory)) {
            return $this->sendError('Career History not found');
        }

        $careerHistory = $this->careerHistoryRepository->update($input, $id);

        return $this->sendResponse(new CareerHistoryResource($careerHistory), 'CareerHistory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/careerHistories/{id}",
     *      summary="Remove the specified CareerHistory from storage",
     *      tags={"CareerHistory"},
     *      description="Delete CareerHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of CareerHistory",
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
        /** @var CareerHistory $careerHistory */
        $careerHistory = $this->careerHistoryRepository->find($id);

        if (empty($careerHistory)) {
            return $this->sendError('Career History not found');
        }

        $careerHistory->delete();

        return $this->sendSuccess('Career History deleted successfully');
    }
}
