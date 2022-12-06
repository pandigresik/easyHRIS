<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryBenefitDataTable;

use App\Http\Requests\Hr\CreateSalaryBenefitRequest;
use App\Http\Requests\Hr\UpdateSalaryBenefitRequest;
use App\Repositories\Hr\SalaryBenefitRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\Employee;
use App\Models\Hr\SalaryComponent;
use Response;
use Exception;

class SalaryBenefitController extends AppBaseController
{
    /** @var  SalaryBenefitRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SalaryBenefitRepository::class;
    }

    /**
     * Display a listing of the SalaryBenefit.
     *
     * @param SalaryBenefitDataTable $salaryBenefitDataTable
     * @return Response
     */
    public function index(int $employee, SalaryBenefitDataTable $salaryBenefitDataTable)
    {
        $employeeObj = Employee::find($employee);
        $employeeName = $employeeObj->full_name . ' ( '.$employeeObj->code.' )';
        return $salaryBenefitDataTable->setEmployee($employee)->render('hr.salary_benefits.index', ['employee' => $employee, 'employeeName' => $employeeName]);
    }

    /**
     * Show the form for creating a new SalaryBenefit.
     *
     * @return Response
     */
    public function create(int $employee)
    {
        return view('hr.salary_benefits.create')->with($this->getOptionItems($employee))->with(['employee' => $employee]);
    }

    /**
     * Store a newly created SalaryBenefit in storage.
     *
     * @param CreateSalaryBenefitRequest $request
     *
     * @return Response
     */
    public function store(int $employee, CreateSalaryBenefitRequest $request)
    {
        $input = $request->all();
        $input['employee_id'] = $employee;
        $salaryBenefit = $this->getRepositoryObj()->create($input);
        if ($salaryBenefit instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryBenefit->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/salaryBenefits.singular')]));

        return redirect(route('hr.employees.salaryBenefits.index', $employee));
    }

    /**
     * Display the specified SalaryBenefit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(int $employee, $id)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('models/salaryBenefits.singular').' '.__('messages.not_found'));

            return redirect(route('hr.employees.salaryBenefits.index', $employee));
        }

        return view('hr.salary_benefits.show')->with('salaryBenefit', $salaryBenefit)->with(['employee' => $employee]);
    }

    /**
     * Show the form for editing the specified SalaryBenefit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(int $employee, $id)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefits.singular')]));

            return redirect(route('hr.employees.salaryBenefits.index', $employee));
        }
        $optionItems = $this->getOptionItems($employee);
        $optionItems['componentItems'] = $optionItems['componentItems'] + SalaryComponent::find($salaryBenefit->component_id)->pluck('name', 'id')->toArray();

        return view('hr.salary_benefits.edit')->with('salaryBenefit', $salaryBenefit)->with($optionItems)->with(['employee' => $employee]);
    }

    /**
     * Update the specified SalaryBenefit in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryBenefitRequest $request
     *
     * @return Response
     */
    public function update(int $employee, $id, UpdateSalaryBenefitRequest $request)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefits.singular')]));

            return redirect(route('hr.employees.salaryBenefits.index', $employee));
        }
        $input = $request->all();
        $input['employee_id'] = $employee;
        $salaryBenefit = $this->getRepositoryObj()->update($input, $id);
        if ($salaryBenefit instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryBenefit->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryBenefits.singular')]));

        return redirect(route('hr.employees.salaryBenefits.index', $employee));
    }

    /**
     * Remove the specified SalaryBenefit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(int $employee, $id)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefits.singular')]));

            return redirect(route('hr.employees.salaryBenefits.index', $employee));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryBenefits.singular')]));

        return redirect(route('hr.employees.salaryBenefits.index' , $employee));
    }

    /**
     * Provide options item based on relationship model SalaryBenefit from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(int $employee)
    {        
        $salaryComponent = SalaryComponent::whereNotIn('id',function($q) use ($employee) {
            return $q->select('component_id')->from('salary_benefits')->where('employee_id', $employee);
        })->get()->pluck('name', 'id');
        return [            
            'componentItems' => ['' => __('crud.option.salaryComponent_placeholder')] + $salaryComponent->toArray()
        ];
    }
}
