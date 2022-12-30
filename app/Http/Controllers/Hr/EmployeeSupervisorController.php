<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\EmployeeSupervisorDataTable;

use App\Http\Requests\Hr\UpdateEmployeeSupervisorRequest;
use App\Repositories\Hr\EmployeeSupervisorRepository;
use App\Repositories\Base\CompanyRepository;
use App\Repositories\Base\DepartmentRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Base\BusinessUnitRepository;
use Response;
use Exception;
use Illuminate\Http\Request;

class EmployeeSupervisorController extends AppBaseController
{
    /** @var  EmployeeSupervisorRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = EmployeeSupervisorRepository::class;
    }

    /**
     * Display a listing of the Employee.
     *
     * @param EmployeeSupervisorDataTable $employeeSupervisorDataTable
     * @return Response
     */
    public function index(EmployeeSupervisorDataTable $employeeSupervisorDataTable)
    {
        return $employeeSupervisorDataTable->render('hr.employee_supervisors.index');
    }

    /**
     * Display a listing of the Employee.
     *     
     * @return Response
     */
    public function list(Request $request)
    {        
        $data = $this->getRepositoryObj()->list($request->all());
        return view('hr.employee_supervisors.list')->with(['data' => $data]);
    }

    /**
     * Show the form for creating a new Employee.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.employee_supervisors.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Employee in storage.
     *
     * @param UpdateEmployeeSupervisorRequest $request
     *
     * @return Response
     */
    public function store(UpdateEmployeeSupervisorRequest $request)
    {
        $input = $request->all();

        $employee = $this->getRepositoryObj()->create($input);
        if ($employee instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $employee->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/employees.singular')]));

        return redirect(route('hr.employeeSupervisors.index'));
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
        $company = new CompanyRepository();
        $department = new DepartmentRepository();
        $businessUnit = new BusinessUnitRepository();        
        $jobLevel = new JobLevelRepository();
        $jobTitle = new JobTitleRepository();
        $employee = new EmployeeSupervisorRepository();        
        return [            
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck(),
            'businessUnitItems' => $businessUnit->pluck(),            
            'joblevelItems' =>  $jobLevel->pluck(),
            'jobtitleItems' =>  $jobTitle->pluck(),
            'supervisorItems' => ['' => __('crud.option.supervisor_placeholder')] + $employee->allQuery()->supervisor()->get()->pluck('code_name','id')->toArray()
        ];
    }
}
