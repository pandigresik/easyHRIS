<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryBenefitDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateSalaryBenefitRequest;
use App\Http\Requests\Hr\UpdateSalaryBenefitRequest;
use App\Repositories\Hr\SalaryBenefitRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\SalaryComponentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
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
    public function index(SalaryBenefitDataTable $salaryBenefitDataTable)
    {
        return $salaryBenefitDataTable->render('hr.salary_benefits.index');
    }

    /**
     * Show the form for creating a new SalaryBenefit.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.salary_benefits.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SalaryBenefit in storage.
     *
     * @param CreateSalaryBenefitRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryBenefitRequest $request)
    {
        $input = $request->all();

        $salaryBenefit = $this->getRepositoryObj()->create($input);
        if($salaryBenefit instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $salaryBenefit->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/salaryBenefits.singular')]));

        return redirect(route('hr.salaryBenefits.index'));
    }

    /**
     * Display the specified SalaryBenefit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('models/salaryBenefits.singular').' '.__('messages.not_found'));

            return redirect(route('hr.salaryBenefits.index'));
        }

        return view('hr.salary_benefits.show')->with('salaryBenefit', $salaryBenefit);
    }

    /**
     * Show the form for editing the specified SalaryBenefit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefits.singular')]));

            return redirect(route('hr.salaryBenefits.index'));
        }
        
        return view('hr.salary_benefits.edit')->with('salaryBenefit', $salaryBenefit)->with($this->getOptionItems());
    }

    /**
     * Update the specified SalaryBenefit in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryBenefitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalaryBenefitRequest $request)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefits.singular')]));

            return redirect(route('hr.salaryBenefits.index'));
        }

        $salaryBenefit = $this->getRepositoryObj()->update($request->all(), $id);
        if($salaryBenefit instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $salaryBenefit->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryBenefits.singular')]));

        return redirect(route('hr.salaryBenefits.index'));
    }

    /**
     * Remove the specified SalaryBenefit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryBenefit = $this->getRepositoryObj()->find($id);

        if (empty($salaryBenefit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryBenefits.singular')]));

            return redirect(route('hr.salaryBenefits.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryBenefits.singular')]));

        return redirect(route('hr.salaryBenefits.index'));
    }

    /**
     * Provide options item based on relationship model SalaryBenefit from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $employee = new EmployeeRepository();
        $salaryComponent = new SalaryComponentRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'salaryComponentItems' => ['' => __('crud.option.salaryComponent_placeholder')] + $salaryComponent->pluck()            
        ];
    }
}
