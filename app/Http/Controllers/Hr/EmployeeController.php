<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\EmployeeDataTable;

use App\Http\Requests\Hr\CreateEmployeeRequest;
use App\Http\Requests\Hr\UpdateEmployeeRequest;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\ContractRepository;
use App\Repositories\Base\CityRepository;
use App\Repositories\Base\CompanyRepository;
use App\Repositories\Base\DepartmentRepository;
use App\Repositories\Base\RegionRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Base\Setting;
use App\Repositories\Base\BusinessUnitRepository;
use App\Repositories\Hr\PayrollPeriodGroupRepository;
use App\Repositories\Hr\SalaryGroupRepository;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Carbon\Carbon;
use Response;
use Exception;

class EmployeeController extends AppBaseController
{
    /** @var  EmployeeRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = EmployeeRepository::class;
    }

    /**
     * Display a listing of the Employee.
     *
     * @param EmployeeDataTable $employeeDataTable
     * @return Response
     */
    public function index(EmployeeDataTable $employeeDataTable)
    {
        return $employeeDataTable->render('hr.employees.index');
    }

    /**
     * Show the form for creating a new Employee.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.employees.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Employee in storage.
     *
     * @param CreateEmployeeRequest $request
     *
     * @return Response
     */
    public function store(CreateEmployeeRequest $request)
    {
        $input = $request->all();

        $employee = $this->getRepositoryObj()->create($input);
        if ($employee instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $employee->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/employees.singular')]));

        return redirect(route('hr.employees.index'));
    }

    /**
     * Display the specified Employee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $employee = $this->getRepositoryObj()->find($id);

        if (empty($employee)) {
            Flash::error(__('models/employees.singular').' '.__('messages.not_found'));

            return redirect(route('hr.employees.index'));
        }

        return view('hr.employees.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified Employee.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $employee = $this->getRepositoryObj()->with(['contract'])->find($id);        

        if (empty($employee)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employees.singular')]));

            return redirect(route('hr.employees.index'));
        }

        $timeline = Setting::where(['type' => 'timeline', 'name' => 'max_entry_resign_date'])->first();
        $maxEntry = $timeline->value ?? 30;
        $minDate = localFormatDate(Carbon::now()->subDays($maxEntry)->format('Y-m-d'));
        $optionItems = $this->getOptionItems();
        if($employee->contract_id){
            $optionItems['contractItems'] += [$employee->contract_id => $employee->contract->letter_number];
        }
        return view('hr.employees.edit')->with('employee', $employee)->with($optionItems)->with('minDate', $minDate);;
    }

    /**
     * Update the specified Employee in storage.
     *
     * @param  int              $id
     * @param UpdateEmployeeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEmployeeRequest $request)
    {
        $employee = $this->getRepositoryObj()->find($id);

        if (empty($employee)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employees.singular')]));

            return redirect(route('hr.employees.index'));
        }

        $employee = $this->getRepositoryObj()->update($request->all(), $id);
        if ($employee instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $employee->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/employees.singular')]));

        return redirect(route('hr.employees.index'));
    }

    /**
     * Remove the specified Employee from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $employee = $this->getRepositoryObj()->find($id);

        if (empty($employee)) {
            Flash::error(__('messages.not_found', ['model' => __('models/employees.singular')]));

            return redirect(route('hr.employees.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/employees.singular')]));

        return redirect(route('hr.employees.index'));
    }

    /**
     * Provide options item based on relationship model Employee from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $contract = new ContractRepository();
        $city = new CityRepository();
        $company = new CompanyRepository();
        $department = new DepartmentRepository();
        $businessUnit = new BusinessUnitRepository();
        $region = new RegionRepository();
        $jobLevel = new JobLevelRepository();
        $jobTitle = new JobTitleRepository();
        $employee = new EmployeeRepository();
        $shiftmentGroup = new ShiftmentGroupRepository();
        $salaryGroup = new SalaryGroupRepository();
        $payrollPeriodGroup = new PayrollPeriodGroupRepository();
        return [
            'contractItems' => ['' => __('crud.option.contract_placeholder')] + $contract->allQuery(['used' => 0])->active()->pluck('letter_number', 'id')->toArray(),
            'cityItems' => ['' => __('crud.option.city_placeholder')] + $city->pluck(),
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck(),
            'businessUnitItems' => ['' => __('crud.option.business_unit_placeholder')] + $businessUnit->pluck(),
            'regionItems' => ['' => __('crud.option.region_placeholder')] + $region->pluck(),
            'regionOfBirthItems' => ['' => __('crud.option.region_placeholder')] + $region->pluck(),
            'cityOfBirthItems' => ['' => __('crud.option.city_placeholder')] + $city->pluck(),
            'joblevelItems' => ['' => __('crud.option.jobLevel_placeholder')] + $jobLevel->pluck(),
            'jobtitleItems' => ['' => __('crud.option.jobTitle_placeholder')] + $jobTitle->pluck(),
            'supervisorItems' => ['' => __('crud.option.employee_placeholder')] + $employee->allQuery()->supervisor()->get()->pluck('code_name','id')->toArray(),
            'salaryGroupItems' => ['' => __('crud.option.salary_group_placeholder')] + $salaryGroup->pluck(),
            'shiftmentGroupItems' => ['' => __('crud.option.shiftment_group_placeholder')] + $shiftmentGroup->pluck(),
            'payrollPeriodGroupItems' => ['' => __('crud.option.payroll_period_group_palceholder')] + $payrollPeriodGroup->pluck(),
        ];
    }
}
