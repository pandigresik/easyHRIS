<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\AttendanceDataTable;

use App\Http\Requests\Hr\CreateAttendanceRequest;
use App\Http\Requests\Hr\UpdateAttendanceRequest;
use App\Repositories\Hr\AttendanceRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Response;
use Exception;

class AttendanceController extends AppBaseController
{
    /** @var  AttendanceRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = AttendanceRepository::class;
    }

    /**
     * Display a listing of the Attendance.
     *
     * @param AttendanceDataTable $attendanceDataTable
     * @return Response
     */
    public function index(AttendanceDataTable $attendanceDataTable)
    {
        return 'ok';
        return $attendanceDataTable->render('hr.attendances.index');
    }

    /**
     * Show the form for creating a new Attendance.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.attendances.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Attendance in storage.
     *
     * @param CreateAttendanceRequest $request
     *
     * @return Response
     */
    public function store(CreateAttendanceRequest $request)
    {
        $input = $request->all();

        $attendance = $this->getRepositoryObj()->create($input);
        if($attendance instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $attendance->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/attendances.singular')]));

        return redirect(route('hr.attendances.index'));
    }

    /**
     * Display the specified Attendance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $attendance = $this->getRepositoryObj()->find($id);

        if (empty($attendance)) {
            Flash::error(__('models/attendances.singular').' '.__('messages.not_found'));

            return redirect(route('hr.attendances.index'));
        }

        return view('hr.attendances.show')->with('attendance', $attendance);
    }

    /**
     * Show the form for editing the specified Attendance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $attendance = $this->getRepositoryObj()->find($id);

        if (empty($attendance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendances.singular')]));

            return redirect(route('hr.attendances.index'));
        }
        
        return view('hr.attendances.edit')->with('attendance', $attendance)->with($this->getOptionItems());
    }

    /**
     * Update the specified Attendance in storage.
     *
     * @param  int              $id
     * @param UpdateAttendanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAttendanceRequest $request)
    {
        $attendance = $this->getRepositoryObj()->find($id);

        if (empty($attendance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendances.singular')]));

            return redirect(route('hr.attendances.index'));
        }

        $attendance = $this->getRepositoryObj()->update($request->all(), $id);
        if($attendance instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $attendance->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/attendances.singular')]));

        return redirect(route('hr.attendances.index'));
    }

    /**
     * Remove the specified Attendance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $attendance = $this->getRepositoryObj()->find($id);

        if (empty($attendance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/attendances.singular')]));

            return redirect(route('hr.attendances.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/attendances.singular')]));

        return redirect(route('hr.attendances.index'));
    }

    /**
     * Provide options item based on relationship model Attendance from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $shiftmentGroup = new ShiftmentGroupRepository();
        return [
            'shiftmentGroupItems' => $shiftmentGroup->pluck(),
        ];
    }    
}
