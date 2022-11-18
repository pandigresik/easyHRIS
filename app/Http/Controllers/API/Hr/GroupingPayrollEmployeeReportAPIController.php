<?php

namespace App\Http\Controllers\API\Hr;

use App\Http\Requests\API\Hr\CreateGroupingPayrollEmployeeReportAPIRequest;
use App\Http\Requests\API\Hr\UpdateGroupingPayrollEmployeeReportAPIRequest;
use App\Models\Hr\GroupingPayrollEmployeeReport;
use App\Repositories\Hr\GroupingPayrollEmployeeReportRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\Hr\GroupingPayrollEmployeeReportResource;
use Response;

/**
 * Class GroupingPayrollEmployeeReportController
 * @package App\Http\Controllers\API\Hr
 */

class GroupingPayrollEmployeeReportAPIController extends AppBaseController
{
    /** @var  GroupingPayrollEmployeeReportRepository */
    private $groupingPayrollEmployeeReportRepository;

    public function __construct(GroupingPayrollEmployeeReportRepository $groupingPayrollEmployeeReportRepo)
    {
        $this->groupingPayrollEmployeeReportRepository = $groupingPayrollEmployeeReportRepo;
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/groupingPayrollEmployeeReports",
     *      summary="Get a listing of the GroupingPayrollEmployeeReports.",
     *      tags={"GroupingPayrollEmployeeReport"},
     *      description="Get all GroupingPayrollEmployeeReports",
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
     *                  @SWG\Items(ref="#/definitions/GroupingPayrollEmployeeReport")
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
        $groupingPayrollEmployeeReports = $this->groupingPayrollEmployeeReportRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse(GroupingPayrollEmployeeReportResource::collection($groupingPayrollEmployeeReports), 'Grouping Payroll Employee Reports retrieved successfully');
    }

    /**
     * @param CreateGroupingPayrollEmployeeReportAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/groupingPayrollEmployeeReports",
     *      summary="Store a newly created GroupingPayrollEmployeeReport in storage",
     *      tags={"GroupingPayrollEmployeeReport"},
     *      description="Store GroupingPayrollEmployeeReport",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="GroupingPayrollEmployeeReport that should be stored",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/GroupingPayrollEmployeeReport")
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
     *                  ref="#/definitions/GroupingPayrollEmployeeReport"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateGroupingPayrollEmployeeReportAPIRequest $request)
    {
        $input = $request->all();

        $groupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepository->create($input);

        return $this->sendResponse(new GroupingPayrollEmployeeReportResource($groupingPayrollEmployeeReport), 'Grouping Payroll Employee Report saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/groupingPayrollEmployeeReports/{id}",
     *      summary="Display the specified GroupingPayrollEmployeeReport",
     *      tags={"GroupingPayrollEmployeeReport"},
     *      description="Get GroupingPayrollEmployeeReport",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GroupingPayrollEmployeeReport",
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
     *                  ref="#/definitions/GroupingPayrollEmployeeReport"
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
        /** @var GroupingPayrollEmployeeReport $groupingPayrollEmployeeReport */
        $groupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepository->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            return $this->sendError('Grouping Payroll Employee Report not found');
        }

        return $this->sendResponse(new GroupingPayrollEmployeeReportResource($groupingPayrollEmployeeReport), 'Grouping Payroll Employee Report retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateGroupingPayrollEmployeeReportAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/groupingPayrollEmployeeReports/{id}",
     *      summary="Update the specified GroupingPayrollEmployeeReport in storage",
     *      tags={"GroupingPayrollEmployeeReport"},
     *      description="Update GroupingPayrollEmployeeReport",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GroupingPayrollEmployeeReport",
     *          type="integer",
     *          required=true,
     *          in="path"
     *      ),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="GroupingPayrollEmployeeReport that should be updated",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/GroupingPayrollEmployeeReport")
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
     *                  ref="#/definitions/GroupingPayrollEmployeeReport"
     *              ),
     *              @SWG\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateGroupingPayrollEmployeeReportAPIRequest $request)
    {
        $input = $request->all();

        /** @var GroupingPayrollEmployeeReport $groupingPayrollEmployeeReport */
        $groupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepository->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            return $this->sendError('Grouping Payroll Employee Report not found');
        }

        $groupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepository->update($input, $id);

        return $this->sendResponse(new GroupingPayrollEmployeeReportResource($groupingPayrollEmployeeReport), 'GroupingPayrollEmployeeReport updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/groupingPayrollEmployeeReports/{id}",
     *      summary="Remove the specified GroupingPayrollEmployeeReport from storage",
     *      tags={"GroupingPayrollEmployeeReport"},
     *      description="Delete GroupingPayrollEmployeeReport",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="id",
     *          description="id of GroupingPayrollEmployeeReport",
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
        /** @var GroupingPayrollEmployeeReport $groupingPayrollEmployeeReport */
        $groupingPayrollEmployeeReport = $this->groupingPayrollEmployeeReportRepository->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            return $this->sendError('Grouping Payroll Employee Report not found');
        }

        $groupingPayrollEmployeeReport->delete();

        return $this->sendSuccess('Grouping Payroll Employee Report deleted successfully');
    }
}
