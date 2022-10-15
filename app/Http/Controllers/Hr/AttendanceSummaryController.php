<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\AttendanceSummaryDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateAttendanceSummaryRequest;
use App\Http\Requests\Hr\UpdateAttendanceSummaryRequest;
use App\Repositories\Hr\AttendanceSummaryRepository;
use App\Repositories\Hr\EmployeeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class AttendanceSummaryController extends AppBaseController
{
    /** @var  AttendanceSummaryRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = AttendanceSummaryRepository::class;
    }

    /**
     * Display a listing of the AttendanceSummary.
     *
     * @param AttendanceSummaryDataTable $attendanceSummaryDataTable
     * @return Response
     */
    public function index(AttendanceSummaryDataTable $attendanceSummaryDataTable)
    {
        return $attendanceSummaryDataTable->render('hr.attendance_summaries.index');
    }

    /**
     * Show the form for creating a new AttendanceSummary.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.attendance_summaries.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created AttendanceSummary in storage.
     *
     * @param CreateAttendanceSummaryRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendanceSummaryRequest $request)
    {
        $input = $request->all();

        $attendanceSummary = $this->getRepositoryObj()->create($input);
        if ($attendanceSummary instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $attendanceSummary->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/attendanceSummaries.singular')]));

        return redirect(route('hr.attendanceSummaries.index'));
    }

    /**
     * Display the specified AttendanceSummary.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attendanceSummary = $this->getRepositoryObj()->find($id);

        if (empty($attendanceSummary)) {
            Flash::error(__('models/attendanceSummaries.singular').' '.__('messages.not_found'));

            return redirect(route('hr.attendanceSummaries.index'));
        }

        return view('hr.attendance_summaries.show')->with('attendanceSummary', $attendanceSummary);
    }

    /**
     * Show the form for editing the specified AttendanceSummary.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attendanceSummary = $this->getRepositoryObj()->find($id);

        if (empty($attendanceSummary)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendanceSummaries.singular')]));

            return redirect(route('hr.attendanceSummaries.index'));
        }

        return view('hr.attendance_summaries.edit')->with('attendanceSummary', $attendanceSummary)->with($this->getOptionItems());
    }

    /**
     * Update the specified AttendanceSummary in storage.
     *
     * @param  int              $id
     * @param UpdateAttendanceSummaryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendanceSummaryRequest $request)
    {
        $attendanceSummary = $this->getRepositoryObj()->find($id);

        if (empty($attendanceSummary)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendanceSummaries.singular')]));

            return redirect(route('hr.attendanceSummaries.index'));
        }

        $attendanceSummary = $this->getRepositoryObj()->update($request->all(), $id);
        if ($attendanceSummary instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $attendanceSummary->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/attendanceSummaries.singular')]));

        return redirect(route('hr.attendanceSummaries.index'));
    }

    /**
     * Remove the specified AttendanceSummary from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attendanceSummary = $this->getRepositoryObj()->find($id);

        if (empty($attendanceSummary)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendanceSummaries.singular')]));

            return redirect(route('hr.attendanceSummaries.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/attendanceSummaries.singular')]));

        return redirect(route('hr.attendanceSummaries.index'));
    }

    /**
     * Provide options item based on relationship model AttendanceSummary from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck()
        ];
    }
}
