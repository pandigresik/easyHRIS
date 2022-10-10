<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateEducationalInstituteAPIRequest;
use App\Http\Requests\API\Hr\UpdateEducationalInstituteAPIRequest;
use App\Models\Hr\EducationalInstitute;
use App\Repositories\Hr\EducationalInstituteRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\EducationalInstituteResource;
use Response;

/**
 * Class EducationalInstituteController
 * @package App\Http\Controllers\API\Hr
 */

class EducationalInstituteAPIController extends AppBaseController
{
    /** @var  EducationalInstituteRepository */
    private $educationalInstituteRepository;

    public function __construct(EducationalInstituteRepository $educationalInstituteRepo)
    {
        $this->educationalInstituteRepository = $educationalInstituteRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/educationalInstitutes",
     *      summary="Get a listing of the EducationalInstitutes.",
     *      tags={"EducationalInstitute"},
     *      description="Get all EducationalInstitutes",
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
     *                  @SWG\Items(ref="#/definitions/EducationalInstitute")
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
        $educationalInstitutes = $this->educationalInstituteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(EducationalInstituteResource::collection($educationalInstitutes), 'Educational Institutes retrieved successfully');
    }

    /**
     * @param CreateEducationalInstituteAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/educationalInstitutes",
     *      summary="Store a newly created EducationalInstitute in storage",
     *      tags={"EducationalInstitute"},
     *      description="Store EducationalInstitute",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EducationalInstitute that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EducationalInstitute")
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
     *                  ref="#/definitions/EducationalInstitute"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateEducationalInstituteAPIRequest $request)
    {
        $input = $request->all();

        $educationalInstitute = $this->educationalInstituteRepository->create($input);

        return $this->sendResponse(new EducationalInstituteResource($educationalInstitute), 'Educational Institute saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/educationalInstitutes/{id}",
     *      summary="Display the specified EducationalInstitute",
     *      tags={"EducationalInstitute"},
     *      description="Get EducationalInstitute",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EducationalInstitute",
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
     *                  ref="#/definitions/EducationalInstitute"
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
        /** @var EducationalInstitute $educationalInstitute */
        $educationalInstitute = $this->educationalInstituteRepository->find($id);

        if (empty($educationalInstitute)) {
            return $this->sendError('Educational Institute not found');
        }

        return $this->sendResponse(new EducationalInstituteResource($educationalInstitute), 'Educational Institute retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateEducationalInstituteAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/educationalInstitutes/{id}",
     *      summary="Update the specified EducationalInstitute in storage",
     *      tags={"EducationalInstitute"},
     *      description="Update EducationalInstitute",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EducationalInstitute",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="EducationalInstitute that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/EducationalInstitute")
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
     *                  ref="#/definitions/EducationalInstitute"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateEducationalInstituteAPIRequest $request)
    {
        $input = $request->all();

        /** @var EducationalInstitute $educationalInstitute */
        $educationalInstitute = $this->educationalInstituteRepository->find($id);

        if (empty($educationalInstitute)) {
            return $this->sendError('Educational Institute not found');
        }

        $educationalInstitute = $this->educationalInstituteRepository->update($input, $id);

        return $this->sendResponse(new EducationalInstituteResource($educationalInstitute), 'EducationalInstitute updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/educationalInstitutes/{id}",
     *      summary="Remove the specified EducationalInstitute from storage",
     *      tags={"EducationalInstitute"},
     *      description="Delete EducationalInstitute",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of EducationalInstitute",
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
        /** @var EducationalInstitute $educationalInstitute */
        $educationalInstitute = $this->educationalInstituteRepository->find($id);

        if (empty($educationalInstitute)) {
            return $this->sendError('Educational Institute not found');
        }

        $educationalInstitute->delete();

        return $this->sendSuccess('Educational Institute deleted successfully');
    }
}
