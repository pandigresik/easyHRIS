<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateEducationTitleAPIRequest;
use App\Http\Requests\API\Hr\UpdateEducationTitleAPIRequest;
use App\Models\Hr\EducationTitle;
use App\Repositories\Hr\EducationTitleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\EducationTitleResource;
use Response;

/**
 * Class EducationTitleController
 * @package App\Http\Controllers\API\Hr
 */

class EducationTitleAPIController extends AppBaseController
{
    /** @var  EducationTitleRepository */
    private $educationTitleRepository;

    public function __construct(EducationTitleRepository $educationTitleRepo)
    {
        $this->educationTitleRepository = $educationTitleRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/educationTitles",
     *      summary="Get a listing of the EducationTitles.",
     *      tags={"EducationTitle"},
     *      description="Get all EducationTitles",
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
     *                  @SWG\Items(ref="#/definitions/EducationTitle")
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
        $educationTitles = $this->educationTitleRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EducationTitleResource::collection($educationTitles), 'Education Titles retrieved successfully');
    }

    /**
     * @param CreateEducationTitleAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/educationTitles",
     *      summary="Store a newly created EducationTitle in storage",
     *      tags={"EducationTitle"},
     *      description="Store EducationTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EducationTitle that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EducationTitle")
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
     *                  ref="#/definitions/EducationTitle"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEducationTitleAPIRequest $request)
    {
        $input = $request->all();

        $educationTitle = $this->educationTitleRepository->create($input);

        return $this->sendResponse(new EducationTitleResource($educationTitle), 'Education Title saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/educationTitles/{id}",
     *      summary="Display the specified EducationTitle",
     *      tags={"EducationTitle"},
     *      description="Get EducationTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EducationTitle",
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
     *                  ref="#/definitions/EducationTitle"
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
        /** @var EducationTitle $educationTitle */
        $educationTitle = $this->educationTitleRepository->find($id);

        if (empty($educationTitle)) {
            return $this->sendError('Education Title not found');
        }

        return $this->sendResponse(new EducationTitleResource($educationTitle), 'Education Title retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEducationTitleAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/educationTitles/{id}",
     *      summary="Update the specified EducationTitle in storage",
     *      tags={"EducationTitle"},
     *      description="Update EducationTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EducationTitle",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EducationTitle that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EducationTitle")
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
     *                  ref="#/definitions/EducationTitle"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEducationTitleAPIRequest $request)
    {
        $input = $request->all();

        /** @var EducationTitle $educationTitle */
        $educationTitle = $this->educationTitleRepository->find($id);

        if (empty($educationTitle)) {
            return $this->sendError('Education Title not found');
        }

        $educationTitle = $this->educationTitleRepository->update($input, $id);

        return $this->sendResponse(new EducationTitleResource($educationTitle), 'EducationTitle updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/educationTitles/{id}",
     *      summary="Remove the specified EducationTitle from storage",
     *      tags={"EducationTitle"},
     *      description="Delete EducationTitle",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EducationTitle",
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
        /** @var EducationTitle $educationTitle */
        $educationTitle = $this->educationTitleRepository->find($id);

        if (empty($educationTitle)) {
            return $this->sendError('Education Title not found');
        }

        $educationTitle->delete();

        return $this->sendSuccess('Education Title deleted successfully');
    }
}
