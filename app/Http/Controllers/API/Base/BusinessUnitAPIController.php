<?php

namespace App\Http\Controllers\API\Base;

use App\Http\Requests\API\Base\CreateBusinessUnitAPIRequest;
use App\Http\Requests\API\Base\UpdateBusinessUnitAPIRequest;
use App\Models\Base\BusinessUnit;
use App\Repositories\Base\BusinessUnitRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Base\BusinessUnitResource;
use Response;

/**
 * Class BusinessUnitController
 * @package App\Http\Controllers\API\Base
 */

class BusinessUnitAPIController extends AppBaseController
{
    /** @var  BusinessUnitRepository */
    private $businessUnitRepository;

    public function __construct(BusinessUnitRepository $businessUnitRepo)
    {
        $this->businessUnitRepository = $businessUnitRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/businessUnits",
     *      summary="Get a listing of the BusinessUnits.",
     *      tags={"BusinessUnit"},
     *      description="Get all BusinessUnits",
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
     *                  @SWG\Items(ref="#/definitions/BusinessUnit")
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
        $businessUnits = $this->businessUnitRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(BusinessUnitResource::collection($businessUnits), 'Business Units retrieved successfully');
    }

    /**
     * @param CreateBusinessUnitAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/businessUnits",
     *      summary="Store a newly created BusinessUnit in storage",
     *      tags={"BusinessUnit"},
     *      description="Store BusinessUnit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BusinessUnit that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BusinessUnit")
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
     *                  ref="#/definitions/BusinessUnit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateBusinessUnitAPIRequest $request)
    {
        $input = $request->all();

        $businessUnit = $this->businessUnitRepository->create($input);

        return $this->sendResponse(new BusinessUnitResource($businessUnit), 'Business Unit saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/businessUnits/{id}",
     *      summary="Display the specified BusinessUnit",
     *      tags={"BusinessUnit"},
     *      description="Get BusinessUnit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BusinessUnit",
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
     *                  ref="#/definitions/BusinessUnit"
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
        /** @var BusinessUnit $businessUnit */
        $businessUnit = $this->businessUnitRepository->find($id);

        if (empty($businessUnit)) {
            return $this->sendError('Business Unit not found');
        }

        return $this->sendResponse(new BusinessUnitResource($businessUnit), 'Business Unit retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateBusinessUnitAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/businessUnits/{id}",
     *      summary="Update the specified BusinessUnit in storage",
     *      tags={"BusinessUnit"},
     *      description="Update BusinessUnit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BusinessUnit",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="BusinessUnit that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/BusinessUnit")
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
     *                  ref="#/definitions/BusinessUnit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateBusinessUnitAPIRequest $request)
    {
        $input = $request->all();

        /** @var BusinessUnit $businessUnit */
        $businessUnit = $this->businessUnitRepository->find($id);

        if (empty($businessUnit)) {
            return $this->sendError('Business Unit not found');
        }

        $businessUnit = $this->businessUnitRepository->update($input, $id);

        return $this->sendResponse(new BusinessUnitResource($businessUnit), 'BusinessUnit updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/businessUnits/{id}",
     *      summary="Remove the specified BusinessUnit from storage",
     *      tags={"BusinessUnit"},
     *      description="Delete BusinessUnit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of BusinessUnit",
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
        /** @var BusinessUnit $businessUnit */
        $businessUnit = $this->businessUnitRepository->find($id);

        if (empty($businessUnit)) {
            return $this->sendError('Business Unit not found');
        }

        $businessUnit->delete();

        return $this->sendSuccess('Business Unit deleted successfully');
    }
}
