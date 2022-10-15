<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\PayrollPeriodDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreatePayrollPeriodRequest;
use App\Http\Requests\Hr\UpdatePayrollPeriodRequest;
use App\Repositories\Hr\PayrollPeriodRepository;
use App\Repositories\Hr\CompanyRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class PayrollPeriodController extends AppBaseController
{
    /** @var  PayrollPeriodRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = PayrollPeriodRepository::class;
    }

    /**
     * Display a listing of the PayrollPeriod.
     *
     * @param PayrollPeriodDataTable $payrollPeriodDataTable
     * @return Response
     */
    public function index(PayrollPeriodDataTable $payrollPeriodDataTable)
    {
        return $payrollPeriodDataTable->render('hr.payroll_periods.index');
    }

    /**
     * Show the form for creating a new PayrollPeriod.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.payroll_periods.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created PayrollPeriod in storage.
     *
     * @param CreatePayrollPeriodRequest $request
     *
     * @return Response
     */
    public function store(CreatePayrollPeriodRequest $request)
    {
        $input = $request->all();

        $payrollPeriod = $this->getRepositoryObj()->create($input);
        if ($payrollPeriod instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $payrollPeriod->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route('hr.payrollPeriods.index'));
    }

    /**
     * Display the specified PayrollPeriod.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('models/payrollPeriods.singular').' '.__('messages.not_found'));

            return redirect(route('hr.payrollPeriods.index'));
        }

        return view('hr.payroll_periods.show')->with('payrollPeriod', $payrollPeriod);
    }

    /**
     * Show the form for editing the specified PayrollPeriod.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriods.singular')]));

            return redirect(route('hr.payrollPeriods.index'));
        }

        return view('hr.payroll_periods.edit')->with('payrollPeriod', $payrollPeriod)->with($this->getOptionItems());
    }

    /**
     * Update the specified PayrollPeriod in storage.
     *
     * @param  int              $id
     * @param UpdatePayrollPeriodRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayrollPeriodRequest $request)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriods.singular')]));

            return redirect(route('hr.payrollPeriods.index'));
        }

        $payrollPeriod = $this->getRepositoryObj()->update($request->all(), $id);
        if ($payrollPeriod instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $payrollPeriod->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route('hr.payrollPeriods.index'));
    }

    /**
     * Remove the specified PayrollPeriod from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payrollPeriod = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriod)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriods.singular')]));

            return redirect(route('hr.payrollPeriods.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/payrollPeriods.singular')]));

        return redirect(route('hr.payrollPeriods.index'));
    }

    /**
     * Provide options item based on relationship model PayrollPeriod from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $company = new CompanyRepository();
        return [
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck()
        ];
    }
}