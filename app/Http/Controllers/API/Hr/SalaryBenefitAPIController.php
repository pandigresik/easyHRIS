<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateSalaryBenefitAPIRequest;
use App\Http\Requests\API\Hr\UpdateSalaryBenefitAPIRequest;
use App\Models\Hr\SalaryBenefit;
use App\Repositories\Hr\SalaryBenefitRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\SalaryBenefitResource;
use Response;

/**
 * Class SalaryBenefitController
 * @package App\Http\Controllers\API\Hr
 */

class SalaryBenefitAPIController extends AppBaseController
{
    /** @var  SalaryBenefitRepository */
    private $salaryBenefitRepository;

    public function __construct(SalaryBenefitRepository $salaryBenefitRepo)
    {
        $this->salaryBenefitRepository = $salaryBenefitRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryBenefits",
     *      summary="Get a listing of the SalaryBenefits.",
     *      tags={"SalaryBenefit"},
     *      description="Get all SalaryBenefits",
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
     *                  @SWG\Items(ref="#/definitions/SalaryBenefit")
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
        $salaryBenefits = $this->salaryBenefitRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(SalaryBenefitResource::collection($salaryBenefits), 'Salary Benefits retrieved successfully');
    }

    /**
     * @param CreateSalaryBenefitAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/salaryBenefits",
     *      summary="Store a newly created SalaryBenefit in storage",
     *      tags={"SalaryBenefit"},
     *      description="Store SalaryBenefit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryBenefit that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryBenefit")
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
     *                  ref="#/definitions/SalaryBenefit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateSalaryBenefitAPIRequest $request)
    {
        $input = $request->all();

        $salaryBenefit = $this->salaryBenefitRepository->create($input);

        return $this->sendResponse(new SalaryBenefitResource($salaryBenefit), 'Salary Benefit saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/salaryBenefits/{id}",
     *      summary="Display the specified SalaryBenefit",
     *      tags={"SalaryBenefit"},
     *      description="Get SalaryBenefit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryBenefit",
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
     *                  ref="#/definitions/SalaryBenefit"
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
        /** @var SalaryBenefit $salaryBenefit */
        $salaryBenefit = $this->salaryBenefitRepository->find($id);

        if (empty($salaryBenefit)) {
            return $this->sendError('Salary Benefit not found');
        }

        return $this->sendResponse(new SalaryBenefitResource($salaryBenefit), 'Salary Benefit retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateSalaryBenefitAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/salaryBenefits/{id}",
     *      summary="Update the specified SalaryBenefit in storage",
     *      tags={"SalaryBenefit"},
     *      description="Update SalaryBenefit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryBenefit",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="SalaryBenefit that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/SalaryBenefit")
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
     *                  ref="#/definitions/SalaryBenefit"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateSalaryBenefitAPIRequest $request)
    {
        $input = $request->all();

        /** @var SalaryBenefit $salaryBenefit */
        $salaryBenefit = $this->salaryBenefitRepository->find($id);

        if (empty($salaryBenefit)) {
            return $this->sendError('Salary Benefit not found');
        }

        $salaryBenefit = $this->salaryBenefitRepository->update($input, $id);

        return $this->sendResponse(new SalaryBenefitResource($salaryBenefit), 'SalaryBenefit updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/salaryBenefits/{id}",
     *      summary="Remove the specified SalaryBenefit from storage",
     *      tags={"SalaryBenefit"},
     *      description="Delete SalaryBenefit",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of SalaryBenefit",
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
        /** @var SalaryBenefit $salaryBenefit */
        $salaryBenefit = $this->salaryBenefitRepository->find($id);

        if (empty($salaryBenefit)) {
            return $this->sendError('Salary Benefit not found');
        }

        $salaryBenefit->delete();

        return $this->sendSuccess('Salary Benefit deleted successfully');
    }
}
