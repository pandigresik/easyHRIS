<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateContractAPIRequest;
use App\Http\Requests\API\Hr\UpdateContractAPIRequest;
use App\Models\Hr\Contract;
use App\Repositories\Hr\ContractRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\ContractResource;
use Response;

/**
 * Class ContractController
 * @package App\Http\Controllers\API\Hr
 */

class ContractAPIController extends AppBaseController
{
    /** @var  ContractRepository */
    private $contractRepository;

    public function __construct(ContractRepository $contractRepo)
    {
        $this->contractRepository = $contractRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/contracts",
     *      summary="Get a listing of the Contracts.",
     *      tags={"Contract"},
     *      description="Get all Contracts",
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
     *                  @SWG\Items(ref="#/definitions/Contract")
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
        $contracts = $this->contractRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ContractResource::collection($contracts), 'Contracts retrieved successfully');
    }

    /**
     * @param CreateContractAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/contracts",
     *      summary="Store a newly created Contract in storage",
     *      tags={"Contract"},
     *      description="Store Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Contract that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Contract")
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
     *                  ref="#/definitions/Contract"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateContractAPIRequest $request)
    {
        $input = $request->all();

        $contract = $this->contractRepository->create($input);

        return $this->sendResponse(new ContractResource($contract), 'Contract saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/contracts/{id}",
     *      summary="Display the specified Contract",
     *      tags={"Contract"},
     *      description="Get Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contract",
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
     *                  ref="#/definitions/Contract"
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
        /** @var Contract $contract */
        $contract = $this->contractRepository->find($id);

        if (empty($contract)) {
            return $this->sendError('Contract not found');
        }

        return $this->sendResponse(new ContractResource($contract), 'Contract retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateContractAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/contracts/{id}",
     *      summary="Update the specified Contract in storage",
     *      tags={"Contract"},
     *      description="Update Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contract",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Contract that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Contract")
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
     *                  ref="#/definitions/Contract"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateContractAPIRequest $request)
    {
        $input = $request->all();

        /** @var Contract $contract */
        $contract = $this->contractRepository->find($id);

        if (empty($contract)) {
            return $this->sendError('Contract not found');
        }

        $contract = $this->contractRepository->update($input, $id);

        return $this->sendResponse(new ContractResource($contract), 'Contract updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/contracts/{id}",
     *      summary="Remove the specified Contract from storage",
     *      tags={"Contract"},
     *      description="Delete Contract",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Contract",
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
        /** @var Contract $contract */
        $contract = $this->contractRepository->find($id);

        if (empty($contract)) {
            return $this->sendError('Contract not found');
        }

        $contract->delete();

        return $this->sendSuccess('Contract deleted successfully');
    }
}
