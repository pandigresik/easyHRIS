<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\EmployeeShiftmentDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateEmployeeShiftmentRequest;
use App\Http\Requests\Hr\UpdateEmployeeShiftmentRequest;
use App\Repositories\Hr\EmployeeShiftmentRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class EmployeeShiftmentController extends AppBaseController
{
    /** @var  EmployeeShiftmentRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = EmployeeShiftmentRepository::class;
    }

    /**
     * Display a listing of the EmployeeShiftment.
     *
     * @param EmployeeShiftmentDataTable $employeeShiftmentDataTable
     * @return Response
     */
    public function index(EmployeeShiftmentDataTable $employeeShiftmentDataTable)
    {
        return $employeeShiftmentDataTable->render('hr.employee_shiftments.index');
    }

    /**
     * Show the form for creating a new EmployeeShiftment.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.employee_shiftments.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created EmployeeShiftment in storage.
     *
     * @param CreateEmployeeShiftmentRequest $request
     *
     * @return Response
     */
    public function store(CreateEmployeeShiftmentRequest $request)
    {
        $input = $request->all();

        $employeeShiftment = $this->getRepositoryObj()->create($input);
        if ($employeeShiftment instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $employeeShiftment->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/employeeShiftments.singular')]));

        return redirect(route('hr.employeeShiftments.index'));
    }

    /**
     * Display the specified EmployeeShiftment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $employeeShiftment = $this->getRepositoryObj()->find($id);

        if (empty($employeeShiftment)) {
            Flash::error(__('models/employeeShiftments.singular').' '.__('messages.not_found'));

            return redirect(route('hr.employeeShiftments.index'));
        }

        return view('hr.employee_shiftments.show')->with('employeeShiftment', $employeeShiftment);
    }

    /**
     * Show the form for editing the specified EmployeeShiftment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $employeeShiftment = $this->getRepositoryObj()->find($id);

        if (empty($employeeShiftment)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employeeShiftments.singular')]));

            return redirect(route('hr.employeeShiftments.index'));
        }

        return view('hr.employee_shiftments.edit')->with('employeeShiftment', $employeeShiftment)->with($this->getOptionItems());
    }

    /**
     * Update the specified EmployeeShiftment in storage.
     *
     * @param  int              $id
     * @param UpdateEmployeeShiftmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmployeeShiftmentRequest $request)
    {
        $employeeShiftment = $this->getRepositoryObj()->find($id);

        if (empty($employeeShiftment)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employeeShiftments.singular')]));

            return redirect(route('hr.employeeShiftments.index'));
        }

        $employeeShiftment = $this->getRepositoryObj()->update($request->all(), $id);
        if ($employeeShiftment instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $employeeShiftment->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/employeeShiftments.singular')]));

        return redirect(route('hr.employeeShiftments.index'));
    }

    /**
     * Remove the specified EmployeeShiftment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $employeeShiftment = $this->getRepositoryObj()->find($id);

        if (empty($employeeShiftment)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employeeShiftments.singular')]));

            return redirect(route('hr.employeeShiftments.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/employeeShiftments.singular')]));

        return redirect(route('hr.employeeShiftments.index'));
    }

    /**
     * Provide options item based on relationship model EmployeeShiftment from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        $shiftmentGroup = new ShiftmentGroupRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'shiftmentGroupItems' => ['' => __('crud.option.shiftmentGroup_placeholder')] + $shiftmentGroup->pluck()
        ];
    }
}
