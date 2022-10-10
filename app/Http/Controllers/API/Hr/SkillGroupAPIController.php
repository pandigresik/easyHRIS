<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSkillGroupAPIRequest;
use App\Http\Requests\API\Hr\UpdateSkillGroupAPIRequest;
use App\Models\Hr\SkillGroup;
use App\Repositories\Hr\SkillGroupRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SkillGroupResource;
use Response;

/**
 * Class SkillGroupController
 * @package App\Http\Controllers\API\Hr
 */

class SkillGroupAPIController extends AppBaseController
{
    /** @var  SkillGroupRepository */
    private $skillGroupRepository;

    public function __construct(SkillGroupRepository $skillGroupRepo)
    {
        $this->skillGroupRepository = $skillGroupRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/skillGroups",
     *      summary="Get a listing of the SkillGroups.",
     *      tags={"SkillGroup"},
     *      description="Get all SkillGroups",
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
     *                  @SWG\Items(ref="#/definitions/SkillGroup")
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
        $skillGroups = $this->skillGroupRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SkillGroupResource::collection($skillGroups), 'Skill Groups retrieved successfully');
    }

    /**
     * @param CreateSkillGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/skillGroups",
     *      summary="Store a newly created SkillGroup in storage",
     *      tags={"SkillGroup"},
     *      description="Store SkillGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SkillGroup that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SkillGroup")
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
     *                  ref="#/definitions/SkillGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSkillGroupAPIRequest $request)
    {
        $input = $request->all();

        $skillGroup = $this->skillGroupRepository->create($input);

        return $this->sendResponse(new SkillGroupResource($skillGroup), 'Skill Group saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/skillGroups/{id}",
     *      summary="Display the specified SkillGroup",
     *      tags={"SkillGroup"},
     *      description="Get SkillGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SkillGroup",
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
     *                  ref="#/definitions/SkillGroup"
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
        /** @var SkillGroup $skillGroup */
        $skillGroup = $this->skillGroupRepository->find($id);

        if (empty($skillGroup)) {
            return $this->sendError('Skill Group not found');
        }

        return $this->sendResponse(new SkillGroupResource($skillGroup), 'Skill Group retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSkillGroupAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/skillGroups/{id}",
     *      summary="Update the specified SkillGroup in storage",
     *      tags={"SkillGroup"},
     *      description="Update SkillGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SkillGroup",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SkillGroup that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SkillGroup")
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
     *                  ref="#/definitions/SkillGroup"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSkillGroupAPIRequest $request)
    {
        $input = $request->all();

        /** @var SkillGroup $skillGroup */
        $skillGroup = $this->skillGroupRepository->find($id);

        if (empty($skillGroup)) {
            return $this->sendError('Skill Group not found');
        }

        $skillGroup = $this->skillGroupRepository->update($input, $id);

        return $this->sendResponse(new SkillGroupResource($skillGroup), 'SkillGroup updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/skillGroups/{id}",
     *      summary="Remove the specified SkillGroup from storage",
     *      tags={"SkillGroup"},
     *      description="Delete SkillGroup",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SkillGroup",
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
        /** @var SkillGroup $skillGroup */
        $skillGroup = $this->skillGroupRepository->find($id);

        if (empty($skillGroup)) {
            return $this->sendError('Skill Group not found');
        }

        $skillGroup->delete();

        return $this->sendSuccess('Skill Group deleted successfully');
    }
}
