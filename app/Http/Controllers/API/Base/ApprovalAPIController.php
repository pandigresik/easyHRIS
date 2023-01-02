<?php

namespace App\Http\Controllers\API\Base;

use App\Http\Requests\API\Base\CreateApprovalAPIRequest;
use App\Http\Requests\API\Base\UpdateApprovalAPIRequest;
use App\Models\Base\Approval;
use App\Repositories\Base\ApprovalRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Base\ApprovalResource;
use Response;

/**
 * Class ApprovalController
 * @package App\Http\Controllers\API\Base
 */

class ApprovalAPIController extends AppBaseController
{
    /** @var  ApprovalRepository */
    private $approvalRepository;

    public function __construct(ApprovalRepository $approvalRepo)
    {
        $this->approvalRepository = $approvalRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/approvals",
     *      summary="Get a listing of the Approvals.",
     *      tags={"Approval"},
     *      description="Get all Approvals",
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
     *                  @SWG\Items(ref="#/definitions/Approval")
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
        $approvals = $this->approvalRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(ApprovalResource::collection($approvals), 'Approvals retrieved successfully');
    }

    /**
     * @param CreateApprovalAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/approvals",
     *      summary="Store a newly created Approval in storage",
     *      tags={"Approval"},
     *      description="Store Approval",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Approval that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Approval")
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
     *                  ref="#/definitions/Approval"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateApprovalAPIRequest $request)
    {
        $input = $request->all();

        $approval = $this->approvalRepository->create($input);

        return $this->sendResponse(new ApprovalResource($approval), 'Approval saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/approvals/{id}",
     *      summary="Display the specified Approval",
     *      tags={"Approval"},
     *      description="Get Approval",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Approval",
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
     *                  ref="#/definitions/Approval"
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
        /** @var Approval $approval */
        $approval = $this->approvalRepository->find($id);

        if (empty($approval)) {
            return $this->sendError('Approval not found');
        }

        return $this->sendResponse(new ApprovalResource($approval), 'Approval retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateApprovalAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/approvals/{id}",
     *      summary="Update the specified Approval in storage",
     *      tags={"Approval"},
     *      description="Update Approval",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Approval",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Approval that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Approval")
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
     *                  ref="#/definitions/Approval"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateApprovalAPIRequest $request)
    {
        $input = $request->all();

        /** @var Approval $approval */
        $approval = $this->approvalRepository->find($id);

        if (empty($approval)) {
            return $this->sendError('Approval not found');
        }

        $approval = $this->approvalRepository->update($input, $id);

        return $this->sendResponse(new ApprovalResource($approval), 'Approval updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/approvals/{id}",
     *      summary="Remove the specified Approval from storage",
     *      tags={"Approval"},
     *      description="Delete Approval",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Approval",
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
        /** @var Approval $approval */
        $approval = $this->approvalRepository->find($id);

        if (empty($approval)) {
            return $this->sendError('Approval not found');
        }

        $approval->delete();

        return $this->sendSuccess('Approval deleted successfully');
    }
}
