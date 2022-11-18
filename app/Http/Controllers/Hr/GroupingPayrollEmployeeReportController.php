<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\GroupingPayrollEmployeeReportDataTable;
use App\Http\Requests\Hr\CreateGroupingPayrollEmployeeReportRequest;
use App\Http\Requests\Hr\UpdateGroupingPayrollEmployeeReportRequest;
use App\Repositories\Hr\GroupingPayrollEmployeeReportRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\Employee;
use App\Repositories\Hr\GroupingPayrollEntityRepository;
use Response;
use Exception;

class GroupingPayrollEmployeeReportController extends AppBaseController
{
    /** @var  GroupingPayrollEmployeeReportRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = GroupingPayrollEmployeeReportRepository::class;
    }

    /**
     * Display a listing of the GroupingPayrollEmployeeReport.
     *
     * @param GroupingPayrollEmployeeReportDataTable $groupingPayrollEmployeeReportDataTable
     * @return Response
     */
    public function index(GroupingPayrollEmployeeReportDataTable $groupingPayrollEmployeeReportDataTable)
    {
        return $groupingPayrollEmployeeReportDataTable->render('hr.grouping_payroll_employee_reports.index');
    }

    /**
     * Show the form for creating a new GroupingPayrollEmployeeReport.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.grouping_payroll_employee_reports.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created GroupingPayrollEmployeeReport in storage.
     *
     * @param CreateGroupingPayrollEmployeeReportRequest $request
     *
     * @return Response
     */
    public function store(CreateGroupingPayrollEmployeeReportRequest $request)
    {
        $input = $request->all();

        $groupingPayrollEmployeeReport = $this->getRepositoryObj()->create($input);
        if($groupingPayrollEmployeeReport instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $groupingPayrollEmployeeReport->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/groupingPayrollEmployeeReports.singular')]));

        return redirect(route('hr.groupingPayrollEmployeeReports.index'));
    }

    /**
     * Display the specified GroupingPayrollEmployeeReport.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $groupingPayrollEmployeeReport = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            Flash::error(__('models/groupingPayrollEmployeeReports.singular').' '.__('messages.not_found'));

            return redirect(route('hr.groupingPayrollEmployeeReports.index'));
        }

        return view('hr.grouping_payroll_employee_reports.show')->with('groupingPayrollEmployeeReport', $groupingPayrollEmployeeReport);
    }

    /**
     * Show the form for editing the specified GroupingPayrollEmployeeReport.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $groupingPayrollEmployeeReport = $this->getRepositoryObj()->with(['employee'])->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            Flash::error(__('messages.not_found', ['model' => __('models/groupingPayrollEmployeeReports.singular')]));

            return redirect(route('hr.groupingPayrollEmployeeReports.index'));
        }
        $optionItems = $this->getOptionItems();
        $optionItems['employeeItems'] = [$groupingPayrollEmployeeReport->employee_id => $groupingPayrollEmployeeReport->employee->full_name .'('.$groupingPayrollEmployeeReport->employee->code.')']; 
        return view('hr.grouping_payroll_employee_reports.edit')->with('groupingPayrollEmployeeReport', $groupingPayrollEmployeeReport)->with($optionItems);
    }

    /**
     * Update the specified GroupingPayrollEmployeeReport in storage.
     *
     * @param  int              $id
     * @param UpdateGroupingPayrollEmployeeReportRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGroupingPayrollEmployeeReportRequest $request)
    {
        $groupingPayrollEmployeeReport = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            Flash::error(__('messages.not_found', ['model' => __('models/groupingPayrollEmployeeReports.singular')]));

            return redirect(route('hr.groupingPayrollEmployeeReports.index'));
        }

        $groupingPayrollEmployeeReport = $this->getRepositoryObj()->update($request->all(), $id);
        if($groupingPayrollEmployeeReport instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $groupingPayrollEmployeeReport->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/groupingPayrollEmployeeReports.singular')]));

        return redirect(route('hr.groupingPayrollEmployeeReports.index'));
    }

    /**
     * Remove the specified GroupingPayrollEmployeeReport from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $groupingPayrollEmployeeReport = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEmployeeReport)) {
            Flash::error(__('messages.not_found', ['model' => __('models/groupingPayrollEmployeeReports.singular')]));

            return redirect(route('hr.groupingPayrollEmployeeReports.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/groupingPayrollEmployeeReports.singular')]));

        return redirect(route('hr.groupingPayrollEmployeeReports.index'));
    }

    /**
     * Provide options item based on relationship model GroupingPayrollEmployeeReport from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $groupingPayrollEntity = new GroupingPayrollEntityRepository();
        return [
            'groupingPayrollEntityItems' => $groupingPayrollEntity->pluck(),
            'employeeItems' => []
        ];
    }
}
