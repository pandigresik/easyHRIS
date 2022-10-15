<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\AttendanceLogfingerDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateAttendanceLogfingerRequest;
use App\Http\Requests\Hr\UpdateAttendanceLogfingerRequest;
use App\Repositories\Hr\AttendanceLogfingerRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\FingerprintDeviceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class AttendanceLogfingerController extends AppBaseController
{
    /** @var  AttendanceLogfingerRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = AttendanceLogfingerRepository::class;
    }

    /**
     * Display a listing of the AttendanceLogfinger.
     *
     * @param AttendanceLogfingerDataTable $attendanceLogfingerDataTable
     * @return Response
     */
    public function index(AttendanceLogfingerDataTable $attendanceLogfingerDataTable)
    {
        return $attendanceLogfingerDataTable->render('hr.attendance_logfingers.index');
    }

    /**
     * Show the form for creating a new AttendanceLogfinger.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.attendance_logfingers.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created AttendanceLogfinger in storage.
     *
     * @param CreateAttendanceLogfingerRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendanceLogfingerRequest $request)
    {
        $input = $request->all();

        $attendanceLogfinger = $this->getRepositoryObj()->create($input);
        if ($attendanceLogfinger instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $attendanceLogfinger->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/attendanceLogfingers.singular')]));

        return redirect(route('hr.attendanceLogfingers.index'));
    }

    /**
     * Display the specified AttendanceLogfinger.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attendanceLogfinger = $this->getRepositoryObj()->find($id);

        if (empty($attendanceLogfinger)) {
            Flash::error(__('models/attendanceLogfingers.singular').' '.__('messages.not_found'));

            return redirect(route('hr.attendanceLogfingers.index'));
        }

        return view('hr.attendance_logfingers.show')->with('attendanceLogfinger', $attendanceLogfinger);
    }

    /**
     * Show the form for editing the specified AttendanceLogfinger.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attendanceLogfinger = $this->getRepositoryObj()->find($id);

        if (empty($attendanceLogfinger)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendanceLogfingers.singular')]));

            return redirect(route('hr.attendanceLogfingers.index'));
        }

        return view('hr.attendance_logfingers.edit')->with('attendanceLogfinger', $attendanceLogfinger)->with($this->getOptionItems());
    }

    /**
     * Update the specified AttendanceLogfinger in storage.
     *
     * @param  int              $id
     * @param UpdateAttendanceLogfingerRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendanceLogfingerRequest $request)
    {
        $attendanceLogfinger = $this->getRepositoryObj()->find($id);

        if (empty($attendanceLogfinger)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendanceLogfingers.singular')]));

            return redirect(route('hr.attendanceLogfingers.index'));
        }

        $attendanceLogfinger = $this->getRepositoryObj()->update($request->all(), $id);
        if ($attendanceLogfinger instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $attendanceLogfinger->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/attendanceLogfingers.singular')]));

        return redirect(route('hr.attendanceLogfingers.index'));
    }

    /**
     * Remove the specified AttendanceLogfinger from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attendanceLogfinger = $this->getRepositoryObj()->find($id);

        if (empty($attendanceLogfinger)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendanceLogfingers.singular')]));

            return redirect(route('hr.attendanceLogfingers.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/attendanceLogfingers.singular')]));

        return redirect(route('hr.attendanceLogfingers.index'));
    }

    /**
     * Provide options item based on relationship model AttendanceLogfinger from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        $fingerprintDevice = new FingerprintDeviceRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'fingerprintDeviceItems' => ['' => __('crud.option.fingerprintDevice_placeholder')] + $fingerprintDevice->pluck()
        ];
    }
}