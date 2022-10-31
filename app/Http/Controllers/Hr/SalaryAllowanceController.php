<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryAllowanceDataTable;

use App\Http\Requests\Hr\CreateSalaryAllowanceRequest;
use App\Http\Requests\Hr\UpdateSalaryAllowanceRequest;
use App\Repositories\Hr\SalaryAllowanceRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\SalaryComponentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SalaryAllowanceController extends AppBaseController
{
    /** @var  SalaryAllowanceRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SalaryAllowanceRepository::class;
    }

    /**
     * Display a listing of the SalaryAllowance.
     *
     * @param SalaryAllowanceDataTable $salaryAllowanceDataTable
     * @return Response
     */
    public function index(SalaryAllowanceDataTable $salaryAllowanceDataTable)
    {
        return $salaryAllowanceDataTable->render('hr.salary_allowances.index');
    }

    /**
     * Show the form for creating a new SalaryAllowance.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.salary_allowances.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SalaryAllowance in storage.
     *
     * @param CreateSalaryAllowanceRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryAllowanceRequest $request)
    {
        $input = $request->all();

        $salaryAllowance = $this->getRepositoryObj()->create($input);
        if ($salaryAllowance instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryAllowance->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/salaryAllowances.singular')]));

        return redirect(route('hr.salaryAllowances.index'));
    }

    /**
     * Display the specified SalaryAllowance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salaryAllowance = $this->getRepositoryObj()->find($id);

        if (empty($salaryAllowance)) {
            Flash::error(__('models/salaryAllowances.singular').' '.__('messages.not_found'));

            return redirect(route('hr.salaryAllowances.index'));
        }

        return view('hr.salary_allowances.show')->with('salaryAllowance', $salaryAllowance);
    }

    /**
     * Show the form for editing the specified SalaryAllowance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salaryAllowance = $this->getRepositoryObj()->find($id);

        if (empty($salaryAllowance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryAllowances.singular')]));

            return redirect(route('hr.salaryAllowances.index'));
        }

        return view('hr.salary_allowances.edit')->with('salaryAllowance', $salaryAllowance)->with($this->getOptionItems());
    }

    /**
     * Update the specified SalaryAllowance in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryAllowanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalaryAllowanceRequest $request)
    {
        $salaryAllowance = $this->getRepositoryObj()->find($id);

        if (empty($salaryAllowance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryAllowances.singular')]));

            return redirect(route('hr.salaryAllowances.index'));
        }

        $salaryAllowance = $this->getRepositoryObj()->update($request->all(), $id);
        if ($salaryAllowance instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryAllowance->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryAllowances.singular')]));

        return redirect(route('hr.salaryAllowances.index'));
    }

    /**
     * Remove the specified SalaryAllowance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryAllowance = $this->getRepositoryObj()->find($id);

        if (empty($salaryAllowance)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryAllowances.singular')]));

            return redirect(route('hr.salaryAllowances.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryAllowances.singular')]));

        return redirect(route('hr.salaryAllowances.index'));
    }

    /**
     * Provide options item based on relationship model SalaryAllowance from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        $salaryComponent = new SalaryComponentRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'salaryComponentItems' => ['' => __('crud.option.salaryComponent_placeholder')] + $salaryComponent->pluck()
        ];
    }
}
