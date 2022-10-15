<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\JobPlacementDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateJobPlacementRequest;
use App\Http\Requests\Hr\UpdateJobPlacementRequest;
use App\Repositories\Hr\JobPlacementRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\ContractRepository;
use App\Repositories\Base\CompanyRepository;
use App\Repositories\Base\DepartmentRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class JobPlacementController extends AppBaseController
{
    /** @var  JobPlacementRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = JobPlacementRepository::class;
    }

    /**
     * Display a listing of the JobPlacement.
     *
     * @param JobPlacementDataTable $jobPlacementDataTable
     * @return Response
     */
    public function index(JobPlacementDataTable $jobPlacementDataTable)
    {
        return $jobPlacementDataTable->render('hr.job_placements.index');
    }

    /**
     * Show the form for creating a new JobPlacement.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.job_placements.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created JobPlacement in storage.
     *
     * @param CreateJobPlacementRequest $request
     *
     * @return Response
     */
    public function store(CreateJobPlacementRequest $request)
    {
        $input = $request->all();

        $jobPlacement = $this->getRepositoryObj()->create($input);
        if ($jobPlacement instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $jobPlacement->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/jobPlacements.singular')]));

        return redirect(route('hr.jobPlacements.index'));
    }

    /**
     * Display the specified JobPlacement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobPlacement = $this->getRepositoryObj()->find($id);

        if (empty($jobPlacement)) {
            Flash::error(__('models/jobPlacements.singular').' '.__('messages.not_found'));

            return redirect(route('hr.jobPlacements.index'));
        }

        return view('hr.job_placements.show')->with('jobPlacement', $jobPlacement);
    }

    /**
     * Show the form for editing the specified JobPlacement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobPlacement = $this->getRepositoryObj()->find($id);

        if (empty($jobPlacement)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobPlacements.singular')]));

            return redirect(route('hr.jobPlacements.index'));
        }

        return view('hr.job_placements.edit')->with('jobPlacement', $jobPlacement)->with($this->getOptionItems());
    }

    /**
     * Update the specified JobPlacement in storage.
     *
     * @param  int              $id
     * @param UpdateJobPlacementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobPlacementRequest $request)
    {
        $jobPlacement = $this->getRepositoryObj()->find($id);

        if (empty($jobPlacement)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobPlacements.singular')]));

            return redirect(route('hr.jobPlacements.index'));
        }

        $jobPlacement = $this->getRepositoryObj()->update($request->all(), $id);
        if ($jobPlacement instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $jobPlacement->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/jobPlacements.singular')]));

        return redirect(route('hr.jobPlacements.index'));
    }

    /**
     * Remove the specified JobPlacement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobPlacement = $this->getRepositoryObj()->find($id);

        if (empty($jobPlacement)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobPlacements.singular')]));

            return redirect(route('hr.jobPlacements.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/jobPlacements.singular')]));

        return redirect(route('hr.jobPlacements.index'));
    }

    /**
     * Provide options item based on relationship model JobPlacement from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        $contract = new ContractRepository();
        $supervisor = new EmployeeRepository();
        $company = new CompanyRepository();
        $department = new DepartmentRepository();
        $jobLevel = new JobLevelRepository();
        $jobTitle = new JobTitleRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'contractItems' => ['' => __('crud.option.contract_placeholder')] + $contract->pluck(),
            'supervisorItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck(),
            'jobLevelItems' => ['' => __('crud.option.jobLevel_placeholder')] + $jobLevel->pluck(),
            'jobTitleItems' => ['' => __('crud.option.jobTitle_placeholder')] + $jobTitle->pluck()
        ];
    }
}
