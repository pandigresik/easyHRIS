<?php

namespace App\Http\Controllers\API\Accounting;

use App\Http\Requests\API\Accounting\CreateTaxGroupHistoryAPIRequest;
use App\Http\Requests\API\Accounting\UpdateTaxGroupHistoryAPIRequest;
use App\Models\Accounting\TaxGroupHistory;
use App\Repositories\Accounting\TaxGroupHistoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Accounting\TaxGroupHistoryResource;
use Response;

/**
 * Class TaxGroupHistoryController
 * @package App\Http\Controllers\API\Accounting
 */

class TaxGroupHistoryAPIController extends AppBaseController
{
    /** @var  TaxGroupHistoryRepository */
    private $taxGroupHistoryRepository;

    public function __construct(TaxGroupHistoryRepository $taxGroupHistoryRepo)
    {
        $this->taxGroupHistoryRepository = $taxGroupHistoryRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/taxGroupHistories",
     *      summary="Get a listing of the TaxGroupHistories.",
     *      tags={"TaxGroupHistory"},
     *      description="Get all TaxGroupHistories",
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
     *                  @SWG\Items(ref="#/definitions/TaxGroupHistory")
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
        $taxGroupHistories = $this->taxGroupHistoryRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(TaxGroupHistoryResource::collection($taxGroupHistories), 'Tax Group Histories retrieved successfully');
    }

    /**
     * @param CreateTaxGroupHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/taxGroupHistories",
     *      summary="Store a newly created TaxGroupHistory in storage",
     *      tags={"TaxGroupHistory"},
     *      description="Store TaxGroupHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TaxGroupHistory that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TaxGroupHistory")
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
     *                  ref="#/definitions/TaxGroupHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateTaxGroupHistoryAPIRequest $request)
    {
        $input = $request->all();

        $taxGroupHistory = $this->taxGroupHistoryRepository->create($input);

        return $this->sendResponse(new TaxGroupHistoryResource($taxGroupHistory), 'Tax Group History saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/taxGroupHistories/{id}",
     *      summary="Display the specified TaxGroupHistory",
     *      tags={"TaxGroupHistory"},
     *      description="Get TaxGroupHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TaxGroupHistory",
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
     *                  ref="#/definitions/TaxGroupHistory"
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
        /** @var TaxGroupHistory $taxGroupHistory */
        $taxGroupHistory = $this->taxGroupHistoryRepository->find($id);

        if (empty($taxGroupHistory)) {
            return $this->sendError('Tax Group History not found');
        }

        return $this->sendResponse(new TaxGroupHistoryResource($taxGroupHistory), 'Tax Group History retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateTaxGroupHistoryAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/taxGroupHistories/{id}",
     *      summary="Update the specified TaxGroupHistory in storage",
     *      tags={"TaxGroupHistory"},
     *      description="Update TaxGroupHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TaxGroupHistory",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="TaxGroupHistory that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/TaxGroupHistory")
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
     *                  ref="#/definitions/TaxGroupHistory"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateTaxGroupHistoryAPIRequest $request)
    {
        $input = $request->all();

        /** @var TaxGroupHistory $taxGroupHistory */
        $taxGroupHistory = $this->taxGroupHistoryRepository->find($id);

        if (empty($taxGroupHistory)) {
            return $this->sendError('Tax Group History not found');
        }

        $taxGroupHistory = $this->taxGroupHistoryRepository->update($input, $id);

        return $this->sendResponse(new TaxGroupHistoryResource($taxGroupHistory), 'TaxGroupHistory updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/taxGroupHistories/{id}",
     *      summary="Remove the specified TaxGroupHistory from storage",
     *      tags={"TaxGroupHistory"},
     *      description="Delete TaxGroupHistory",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of TaxGroupHistory",
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
        /** @var TaxGroupHistory $taxGroupHistory */
        $taxGroupHistory = $this->taxGroupHistoryRepository->find($id);

        if (empty($taxGroupHistory)) {
            return $this->sendError('Tax Group History not found');
        }

        $taxGroupHistory->delete();

        return $this->sendSuccess('Tax Group History deleted successfully');
    }
}
