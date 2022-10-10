<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSalaryComponentAPIRequest;
use App\Http\Requests\API\Hr\UpdateSalaryComponentAPIRequest;
use App\Models\Hr\SalaryComponent;
use App\Repositories\Hr\SalaryComponentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SalaryComponentResource;
use Response;

/**
 * Class SalaryComponentController
 * @package App\Http\Controllers\API\Hr
 */

class SalaryComponentAPIController extends AppBaseController
{
    /** @var  SalaryComponentRepository */
    private $salaryComponentRepository;

    public function __construct(SalaryComponentRepository $salaryComponentRepo)
    {
        $this->salaryComponentRepository = $salaryComponentRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryComponents",
     *      summary="Get a listing of the SalaryComponents.",
     *      tags={"SalaryComponent"},
     *      description="Get all SalaryComponents",
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
     *                  @SWG\Items(ref="#/definitions/SalaryComponent")
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
        $salaryComponents = $this->salaryComponentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SalaryComponentResource::collection($salaryComponents), 'Salary Components retrieved successfully');
    }

    /**
     * @param CreateSalaryComponentAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/salaryComponents",
     *      summary="Store a newly created SalaryComponent in storage",
     *      tags={"SalaryComponent"},
     *      description="Store SalaryComponent",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryComponent that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryComponent")
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
     *                  ref="#/definitions/SalaryComponent"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSalaryComponentAPIRequest $request)
    {
        $input = $request->all();

        $salaryComponent = $this->salaryComponentRepository->create($input);

        return $this->sendResponse(new SalaryComponentResource($salaryComponent), 'Salary Component saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryComponents/{id}",
     *      summary="Display the specified SalaryComponent",
     *      tags={"SalaryComponent"},
     *      description="Get SalaryComponent",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryComponent",
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
     *                  ref="#/definitions/SalaryComponent"
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
        /** @var SalaryComponent $salaryComponent */
        $salaryComponent = $this->salaryComponentRepository->find($id);

        if (empty($salaryComponent)) {
            return $this->sendError('Salary Component not found');
        }

        return $this->sendResponse(new SalaryComponentResource($salaryComponent), 'Salary Component retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSalaryComponentAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/salaryComponents/{id}",
     *      summary="Update the specified SalaryComponent in storage",
     *      tags={"SalaryComponent"},
     *      description="Update SalaryComponent",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryComponent",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryComponent that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryComponent")
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
     *                  ref="#/definitions/SalaryComponent"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSalaryComponentAPIRequest $request)
    {
        $input = $request->all();

        /** @var SalaryComponent $salaryComponent */
        $salaryComponent = $this->salaryComponentRepository->find($id);

        if (empty($salaryComponent)) {
            return $this->sendError('Salary Component not found');
        }

        $salaryComponent = $this->salaryComponentRepository->update($input, $id);

        return $this->sendResponse(new SalaryComponentResource($salaryComponent), 'SalaryComponent updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/salaryComponents/{id}",
     *      summary="Remove the specified SalaryComponent from storage",
     *      tags={"SalaryComponent"},
     *      description="Delete SalaryComponent",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryComponent",
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
        /** @var SalaryComponent $salaryComponent */
        $salaryComponent = $this->salaryComponentRepository->find($id);

        if (empty($salaryComponent)) {
            return $this->sendError('Salary Component not found');
        }

        $salaryComponent->delete();

        return $this->sendSuccess('Salary Component deleted successfully');
    }
}
