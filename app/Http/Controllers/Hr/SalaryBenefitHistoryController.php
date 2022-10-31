<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryBenefitHistoryDataTable;

use App\Http\Requests\Hr\CreateSalaryBenefitHistoryRequest;
use App\Http\Requests\Hr\UpdateSalaryBenefitHistoryRequest;
use App\Repositories\Hr\SalaryBenefitHistoryRepository;
use App\Repositories\Hr\ContractRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\SalaryComponentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SalaryBenefitHistoryController extends AppBaseController
{
    /** @var  SalaryBenefitHistoryRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SalaryBenefitHistoryRepository::class;
    }

    /**
     * Display a listing of the SalaryBenefitHistory.
     *
     * @param SalaryBenefitHistoryDataTable $salaryBenefitHistoryDataTable
     * @return Response
     */
    public function index(SalaryBenefitHistoryDataTable $salaryBenefitHistoryDataTable)
    {
        return $salaryBenefitHistoryDataTable->render('hr.salary_benefit_histories.index');
    }

    /**
     * Show the form for creating a new SalaryBenefitHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.salary_benefit_histories.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SalaryBenefitHistory in storage.
     *
     * @param CreateSalaryBenefitHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryBenefitHistoryRequest $request)
    {
        $input = $request->all();

        $salaryBenefitHistory = $this->getRepositoryObj()->create($input);
        if ($salaryBenefitHistory instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryBenefitHistory->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/salaryBenefitHistories.singular')]));

        return redirect(route('hr.salaryBenefitHistories.index'));
    }

    /**
     * Display the specified SalaryBenefitHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salaryBenefitHistory = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefitHistory)) {
            Flash::error(__('models/salaryBenefitHistories.singular').' '.__('messages.not_found'));

            return redirect(route('hr.salaryBenefitHistories.index'));
        }

        return view('hr.salary_benefit_histories.show')->with('salaryBenefitHistory', $salaryBenefitHistory);
    }

    /**
     * Show the form for editing the specified SalaryBenefitHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salaryBenefitHistory = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefitHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefitHistories.singular')]));

            return redirect(route('hr.salaryBenefitHistories.index'));
        }

        return view('hr.salary_benefit_histories.edit')->with('salaryBenefitHistory', $salaryBenefitHistory)->with($this->getOptionItems());
    }

    /**
     * Update the specified SalaryBenefitHistory in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryBenefitHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalaryBenefitHistoryRequest $request)
    {
        $salaryBenefitHistory = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefitHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefitHistories.singular')]));

            return redirect(route('hr.salaryBenefitHistories.index'));
        }

        $salaryBenefitHistory = $this->getRepositoryObj()->update($request->all(), $id);
        if ($salaryBenefitHistory instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryBenefitHistory->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryBenefitHistories.singular')]));

        return redirect(route('hr.salaryBenefitHistories.index'));
    }

    /**
     * Remove the specified SalaryBenefitHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryBenefitHistory = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefitHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefitHistories.singular')]));

            return redirect(route('hr.salaryBenefitHistories.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryBenefitHistories.singular')]));

        return redirect(route('hr.salaryBenefitHistories.index'));
    }

    /**
     * Provide options item based on relationship model SalaryBenefitHistory from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $contract = new ContractRepository();
        $employee = new EmployeeRepository();
        $salaryComponent = new SalaryComponentRepository();
        return [
            'contractItems' => ['' => __('crud.option.contract_placeholder')] + $contract->pluck(),
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'salaryComponentItems' => ['' => __('crud.option.salaryComponent_placeholder')] + $salaryComponent->pluck()
        ];
    }
}
