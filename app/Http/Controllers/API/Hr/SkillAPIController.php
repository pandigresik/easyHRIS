<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSkillAPIRequest;
use App\Http\Requests\API\Hr\UpdateSkillAPIRequest;
use App\Models\Hr\Skill;
use App\Repositories\Hr\SkillRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SkillResource;
use Response;

/**
 * Class SkillController
 * @package App\Http\Controllers\API\Hr
 */

class SkillAPIController extends AppBaseController
{
    /** @var  SkillRepository */
    private $skillRepository;

    public function __construct(SkillRepository $skillRepo)
    {
        $this->skillRepository = $skillRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/skills",
     *      summary="Get a listing of the Skills.",
     *      tags={"Skill"},
     *      description="Get all Skills",
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
     *                  @SWG\Items(ref="#/definitions/Skill")
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
        $skills = $this->skillRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SkillResource::collection($skills), 'Skills retrieved successfully');
    }

    /**
     * @param CreateSkillAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/skills",
     *      summary="Store a newly created Skill in storage",
     *      tags={"Skill"},
     *      description="Store Skill",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Skill that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Skill")
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
     *                  ref="#/definitions/Skill"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSkillAPIRequest $request)
    {
        $input = $request->all();

        $skill = $this->skillRepository->create($input);

        return $this->sendResponse(new SkillResource($skill), 'Skill saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/skills/{id}",
     *      summary="Display the specified Skill",
     *      tags={"Skill"},
     *      description="Get Skill",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Skill",
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
     *                  ref="#/definitions/Skill"
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
        /** @var Skill $skill */
        $skill = $this->skillRepository->find($id);

        if (empty($skill)) {
            return $this->sendError('Skill not found');
        }

        return $this->sendResponse(new SkillResource($skill), 'Skill retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSkillAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/skills/{id}",
     *      summary="Update the specified Skill in storage",
     *      tags={"Skill"},
     *      description="Update Skill",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Skill",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="Skill that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/Skill")
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
     *                  ref="#/definitions/Skill"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSkillAPIRequest $request)
    {
        $input = $request->all();

        /** @var Skill $skill */
        $skill = $this->skillRepository->find($id);

        if (empty($skill)) {
            return $this->sendError('Skill not found');
        }

        $skill = $this->skillRepository->update($input, $id);

        return $this->sendResponse(new SkillResource($skill), 'Skill updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/skills/{id}",
     *      summary="Remove the specified Skill from storage",
     *      tags={"Skill"},
     *      description="Delete Skill",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of Skill",
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
        /** @var Skill $skill */
        $skill = $this->skillRepository->find($id);

        if (empty($skill)) {
            return $this->sendError('Skill not found');
        }

        $skill->delete();

        return $this->sendSuccess('Skill deleted successfully');
    }
}
