<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateLeafAPIRequest;
use App\Http\Requests\API\Hr\UpdateLeafAPIRequest;
use App\Models\Hr\Leaf;
use App\Repositories\Hr\LeafRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\LeafResource;
use Response;

/**
 * Class LeafController
 * @package App\Http\Controllers\API\Hr
 */

class LeafAPIController extends AppBaseController
{
    /** @var  LeafRepository */
    private $leafRepository;

    public function __construct(LeafRepository $leafRepo)
    {
        $this->leafRepository = $leafRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/leaves",
     *      summary="Get a listing of the Leaves.",
     *      tags={"Leaf"},
     *      description="Get all Leaves",
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
     *                  @SWG\Items(ref="#/definitions/Leaf")
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
        $leaves = $this->leafRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(LeafResource::collection($leaves), 'Leaves retrieved successfully');
    }

    /**
     * @param CreateLeafAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/leaves",
     *      summary="Store a newly created Leaf in storage",
     *      tags={"Leaf"},
     *      description="Store Leaf",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Leaf that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Leaf")
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
     *                  ref="#/definitions/Leaf"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateLeafAPIRequest $request)
    {
        $input = $request->all();

        $leaf = $this->leafRepository->create($input);

        return $this->sendResponse(new LeafResource($leaf), 'Leaf saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/leaves/{id}",
     *      summary="Display the specified Leaf",
     *      tags={"Leaf"},
     *      description="Get Leaf",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Leaf",
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
     *                  ref="#/definitions/Leaf"
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
        /** @var Leaf $leaf */
        $leaf = $this->leafRepository->find($id);

        if (empty($leaf)) {
            return $this->sendError('Leaf not found');
        }

        return $this->sendResponse(new LeafResource($leaf), 'Leaf retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateLeafAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/leaves/{id}",
     *      summary="Update the specified Leaf in storage",
     *      tags={"Leaf"},
     *      description="Update Leaf",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Leaf",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Leaf that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Leaf")
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
     *                  ref="#/definitions/Leaf"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateLeafAPIRequest $request)
    {
        $input = $request->all();

        /** @var Leaf $leaf */
        $leaf = $this->leafRepository->find($id);

        if (empty($leaf)) {
            return $this->sendError('Leaf not found');
        }

        $leaf = $this->leafRepository->update($input, $id);

        return $this->sendResponse(new LeafResource($leaf), 'Leaf updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/leaves/{id}",
     *      summary="Remove the specified Leaf from storage",
     *      tags={"Leaf"},
     *      description="Delete Leaf",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Leaf",
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
        /** @var Leaf $leaf */
        $leaf = $this->leafRepository->find($id);

        if (empty($leaf)) {
            return $this->sendError('Leaf not found');
        }

        $leaf->delete();

        return $this->sendSuccess('Leaf deleted successfully');
    }
}
