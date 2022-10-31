<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\ShiftmentScheduleDataTable;

use App\Http\Requests\Hr\CreateShiftmentScheduleRequest;
use App\Http\Requests\Hr\UpdateShiftmentScheduleRequest;
use App\Repositories\Hr\ShiftmentScheduleRepository;
use App\Repositories\Hr\ShiftmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class ShiftmentScheduleController extends AppBaseController
{
    /** @var  ShiftmentScheduleRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = ShiftmentScheduleRepository::class;
    }

    /**
     * Display a listing of the ShiftmentSchedule.
     *
     * @param ShiftmentScheduleDataTable $shiftmentScheduleDataTable
     * @return Response
     */
    public function index(ShiftmentScheduleDataTable $shiftmentScheduleDataTable)
    {
        return $shiftmentScheduleDataTable->render('hr.shiftment_schedules.index');
    }

    /**
     * Show the form for creating a new ShiftmentSchedule.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.shiftment_schedules.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created ShiftmentSchedule in storage.
     *
     * @param CreateShiftmentScheduleRequest $request
     *
     * @return Response
     */
    public function store(CreateShiftmentScheduleRequest $request)
    {
        $input = $request->all();

        $shiftmentSchedule = $this->getRepositoryObj()->create($input);
        if($shiftmentSchedule instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $shiftmentSchedule->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/shiftmentSchedules.singular')]));

        return redirect(route('hr.shiftmentSchedules.index'));
    }

    /**
     * Display the specified ShiftmentSchedule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shiftmentSchedule = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentSchedule)) {
            Flash::error(__('models/shiftmentSchedules.singular').' '.__('messages.not_found'));

            return redirect(route('hr.shiftmentSchedules.index'));
        }

        return view('hr.shiftment_schedules.show')->with('shiftmentSchedule', $shiftmentSchedule);
    }

    /**
     * Show the form for editing the specified ShiftmentSchedule.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shiftmentSchedule = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentSchedule)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentSchedules.singular')]));

            return redirect(route('hr.shiftmentSchedules.index'));
        }
        
        return view('hr.shiftment_schedules.edit')->with('shiftmentSchedule', $shiftmentSchedule)->with($this->getOptionItems());
    }

    /**
     * Update the specified ShiftmentSchedule in storage.
     *
     * @param  int              $id
     * @param UpdateShiftmentScheduleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShiftmentScheduleRequest $request)
    {
        $shiftmentSchedule = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentSchedule)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentSchedules.singular')]));

            return redirect(route('hr.shiftmentSchedules.index'));
        }

        $shiftmentSchedule = $this->getRepositoryObj()->update($request->all(), $id);
        if($shiftmentSchedule instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $shiftmentSchedule->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/shiftmentSchedules.singular')]));

        return redirect(route('hr.shiftmentSchedules.index'));
    }

    /**
     * Remove the specified ShiftmentSchedule from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shiftmentSchedule = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentSchedule)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentSchedules.singular')]));

            return redirect(route('hr.shiftmentSchedules.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/shiftmentSchedules.singular')]));

        return redirect(route('hr.shiftmentSchedules.index'));
    }

    /**
     * Provide options item based on relationship model ShiftmentSchedule from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $shiftment = new ShiftmentRepository();
        return [
            'shiftmentItems' => ['' => __('crud.option.shiftment_placeholder')] + $shiftment->pluck(),
            'workdayItems' => ['' => __('crud.choose').' '.__('crud.workday')] + listWorkDay()
        ];
    }
}
