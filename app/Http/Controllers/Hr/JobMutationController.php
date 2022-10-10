<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\JobMutationDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateJobMutationRequest;
use App\Http\Requests\Hr\UpdateJobMutationRequest;
use App\Repositories\Hr\JobMutationRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\ContractRepository;
use App\Repositories\Hr\CompanyRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\JobTitleRepository;
use App\Repositories\Hr\DepartmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class JobMutationController extends AppBaseController
{
    /** @var  JobMutationRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = JobMutationRepository::class;
    }

    /**
     * Display a listing of the JobMutation.
     *
     * @param JobMutationDataTable $jobMutationDataTable
     * @return Response
     */
    public function index(JobMutationDataTable $jobMutationDataTable)
    {
        return $jobMutationDataTable->render('hr.job_mutations.index');
    }

    /**
     * Show the form for creating a new JobMutation.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.job_mutations.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created JobMutation in storage.
     *
     * @param CreateJobMutationRequest $request
     *
     * @return Response
     */
    public function store(CreateJobMutationRequest $request)
    {
        $input = $request->all();

        $jobMutation = $this->getRepositoryObj()->create($input);
        if($jobMutation instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $jobMutation->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/jobMutations.singular')]));

        return redirect(route('hr.jobMutations.index'));
    }

    /**
     * Display the specified JobMutation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobMutation = $this->getRepositoryObj()->find($id);

        if (empty($jobMutation)) {
            Flash::error(__('models/jobMutations.singular').' '.__('messages.not_found'));

            return redirect(route('hr.jobMutations.index'));
        }

        return view('hr.job_mutations.show')->with('jobMutation', $jobMutation);
    }

    /**
     * Show the form for editing the specified JobMutation.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobMutation = $this->getRepositoryObj()->find($id);

        if (empty($jobMutation)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobMutations.singular')]));

            return redirect(route('hr.jobMutations.index'));
        }
        
        return view('hr.job_mutations.edit')->with('jobMutation', $jobMutation)->with($this->getOptionItems());
    }

    /**
     * Update the specified JobMutation in storage.
     *
     * @param  int              $id
     * @param UpdateJobMutationRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobMutationRequest $request)
    {
        $jobMutation = $this->getRepositoryObj()->find($id);

        if (empty($jobMutation)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobMutations.singular')]));

            return redirect(route('hr.jobMutations.index'));
        }

        $jobMutation = $this->getRepositoryObj()->update($request->all(), $id);
        if($jobMutation instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $jobMutation->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/jobMutations.singular')]));

        return redirect(route('hr.jobMutations.index'));
    }

    /**
     * Remove the specified JobMutation from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobMutation = $this->getRepositoryObj()->find($id);

        if (empty($jobMutation)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobMutations.singular')]));

            return redirect(route('hr.jobMutations.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/jobMutations.singular')]));

        return redirect(route('hr.jobMutations.index'));
    }

    /**
     * Provide options item based on relationship model JobMutation from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $jobLevel = new JobLevelRepository();
        $contract = new ContractRepository();
        $company = new CompanyRepository();
        $jobLevel = new JobLevelRepository();
        $employee = new EmployeeRepository();
        $company = new CompanyRepository();
        $employee = new EmployeeRepository();
        $jobTitle = new JobTitleRepository();
        $jobTitle = new JobTitleRepository();
        $employee = new EmployeeRepository();
        $department = new DepartmentRepository();
        $department = new DepartmentRepository();
        return [
            'jobLevelItems' => ['' => __('crud.option.jobLevel_placeholder')] + $jobLevel->pluck(),
            'contractItems' => ['' => __('crud.option.contract_placeholder')] + $contract->pluck(),
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'jobLevelItems' => ['' => __('crud.option.jobLevel_placeholder')] + $jobLevel->pluck(),
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'jobTitleItems' => ['' => __('crud.option.jobTitle_placeholder')] + $jobTitle->pluck(),
            'jobTitleItems' => ['' => __('crud.option.jobTitle_placeholder')] + $jobTitle->pluck(),
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck()            
        ];
    }
}
