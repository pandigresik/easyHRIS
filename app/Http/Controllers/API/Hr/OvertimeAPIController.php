<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateOvertimeAPIRequest;
use App\Http\Requests\API\Hr\UpdateOvertimeAPIRequest;
use App\Models\Hr\Overtime;
use App\Repositories\Hr\OvertimeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\OvertimeResource;
use Response;

/**
 * Class OvertimeController
 * @package App\Http\Controllers\API\Hr
 */

class OvertimeAPIController extends AppBaseController
{
    /** @var  OvertimeRepository */
    private $overtimeRepository;

    public function __construct(OvertimeRepository $overtimeRepo)
    {
        $this->overtimeRepository = $overtimeRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/overtimes",
     *      summary="Get a listing of the Overtimes.",
     *      tags={"Overtime"},
     *      description="Get all Overtimes",
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
     *                  @SWG\Items(ref="#/definitions/Overtime")
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
        $overtimes = $this->overtimeRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(OvertimeResource::collection($overtimes), 'Overtimes retrieved successfully');
    }

    /**
     * @param CreateOvertimeAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/overtimes",
     *      summary="Store a newly created Overtime in storage",
     *      tags={"Overtime"},
     *      description="Store Overtime",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Overtime that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Overtime")
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
     *                  ref="#/definitions/Overtime"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateOvertimeAPIRequest $request)
    {
        $input = $request->all();

        $overtime = $this->overtimeRepository->create($input);

        return $this->sendResponse(new OvertimeResource($overtime), 'Overtime saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/overtimes/{id}",
     *      summary="Display the specified Overtime",
     *      tags={"Overtime"},
     *      description="Get Overtime",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Overtime",
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
     *                  ref="#/definitions/Overtime"
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
        /** @var Overtime $overtime */
        $overtime = $this->overtimeRepository->find($id);

        if (empty($overtime)) {
            return $this->sendError('Overtime not found');
        }

        return $this->sendResponse(new OvertimeResource($overtime), 'Overtime retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateOvertimeAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/overtimes/{id}",
     *      summary="Update the specified Overtime in storage",
     *      tags={"Overtime"},
     *      description="Update Overtime",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Overtime",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Overtime that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Overtime")
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
     *                  ref="#/definitions/Overtime"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateOvertimeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Overtime $overtime */
        $overtime = $this->overtimeRepository->find($id);

        if (empty($overtime)) {
            return $this->sendError('Overtime not found');
        }

        $overtime = $this->overtimeRepository->update($input, $id);

        return $this->sendResponse(new OvertimeResource($overtime), 'Overtime updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/overtimes/{id}",
     *      summary="Remove the specified Overtime from storage",
     *      tags={"Overtime"},
     *      description="Delete Overtime",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Overtime",
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
        /** @var Overtime $overtime */
        $overtime = $this->overtimeRepository->find($id);

        if (empty($overtime)) {
            return $this->sendError('Overtime not found');
        }

        $overtime->delete();

        return $this->sendSuccess('Overtime deleted successfully');
    }
}
