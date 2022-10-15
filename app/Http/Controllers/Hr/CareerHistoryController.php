<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\CareerHistoryDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateCareerHistoryRequest;
use App\Http\Requests\Hr\UpdateCareerHistoryRequest;
use App\Repositories\Hr\CareerHistoryRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\ContractRepository;
use App\Repositories\Hr\CompanyRepository;
use App\Repositories\Hr\DepartmentRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class CareerHistoryController extends AppBaseController
{
    /** @var  CareerHistoryRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = CareerHistoryRepository::class;
    }

    /**
     * Display a listing of the CareerHistory.
     *
     * @param CareerHistoryDataTable $careerHistoryDataTable
     * @return Response
     */
    public function index(CareerHistoryDataTable $careerHistoryDataTable)
    {
        return $careerHistoryDataTable->render('hr.career_histories.index');
    }

    /**
     * Show the form for creating a new CareerHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.career_histories.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created CareerHistory in storage.
     *
     * @param CreateCareerHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateCareerHistoryRequest $request)
    {
        $input = $request->all();

        $careerHistory = $this->getRepositoryObj()->create($input);
        if ($careerHistory instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $careerHistory->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/careerHistories.singular')]));

        return redirect(route('hr.careerHistories.index'));
    }

    /**
     * Display the specified CareerHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $careerHistory = $this->getRepositoryObj()->find($id);

        if (empty($careerHistory)) {
            Flash::error(__('models/careerHistories.singular').' '.__('messages.not_found'));

            return redirect(route('hr.careerHistories.index'));
        }

        return view('hr.career_histories.show')->with('careerHistory', $careerHistory);
    }

    /**
     * Show the form for editing the specified CareerHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $careerHistory = $this->getRepositoryObj()->find($id);

        if (empty($careerHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/careerHistories.singular')]));

            return redirect(route('hr.careerHistories.index'));
        }

        return view('hr.career_histories.edit')->with('careerHistory', $careerHistory)->with($this->getOptionItems());
    }

    /**
     * Update the specified CareerHistory in storage.
     *
     * @param  int              $id
     * @param UpdateCareerHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCareerHistoryRequest $request)
    {
        $careerHistory = $this->getRepositoryObj()->find($id);

        if (empty($careerHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/careerHistories.singular')]));

            return redirect(route('hr.careerHistories.index'));
        }

        $careerHistory = $this->getRepositoryObj()->update($request->all(), $id);
        if ($careerHistory instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $careerHistory->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/careerHistories.singular')]));

        return redirect(route('hr.careerHistories.index'));
    }

    /**
     * Remove the specified CareerHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $careerHistory = $this->getRepositoryObj()->find($id);

        if (empty($careerHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/careerHistories.singular')]));

            return redirect(route('hr.careerHistories.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/careerHistories.singular')]));

        return redirect(route('hr.careerHistories.index'));
    }

    /**
     * Provide options item based on relationship model CareerHistory from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        $contract = new ContractRepository();
        $employee = new EmployeeRepository();
        $company = new CompanyRepository();
        $department = new DepartmentRepository();
        $jobLevel = new JobLevelRepository();
        $jobTitle = new JobTitleRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'contractItems' => ['' => __('crud.option.contract_placeholder')] + $contract->pluck(),
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'departmentItems' => ['' => __('crud.option.department_placeholder')] + $department->pluck(),
            'jobLevelItems' => ['' => __('crud.option.jobLevel_placeholder')] + $jobLevel->pluck(),
            'jobTitleItems' => ['' => __('crud.option.jobTitle_placeholder')] + $jobTitle->pluck()
        ];
    }
}
