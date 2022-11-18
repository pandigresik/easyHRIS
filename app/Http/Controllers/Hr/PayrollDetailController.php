<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\PayrollDetailDataTable;

use App\Http\Requests\Hr\CreatePayrollDetailRequest;
use App\Http\Requests\Hr\UpdatePayrollDetailRequest;
use App\Repositories\Hr\PayrollDetailRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\Payroll;
use Response;
use Exception;

class PayrollDetailController extends AppBaseController
{
    /** @var  PayrollDetailRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = PayrollDetailRepository::class;
    }

    /**
     * Display a listing of the PayrollDetail.
     *
     * @param PayrollDetailDataTable $payrollDetailDataTable
     * @return Response
     */
    public function index(PayrollDetailDataTable $payrollDetailDataTable)
    {
        $payroll = Payroll::with(['employee', 'payrollPeriod'])->find(request()->get('payroll_id'));
        return $payrollDetailDataTable->setPayrollId($payroll->id)->render('hr.payroll_details.index', ['title' => $payroll->employee->full_name. ' ('.$payroll->employee->code.') '. $payroll->payrollPeriod->name. ' ('.$payroll->take_home_pay.')' ]);
    }

    /**
     * Show the form for creating a new PayrollDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.payroll_details.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created PayrollDetail in storage.
     *
     * @param CreatePayrollDetailRequest $request
     *
     * @return Response
     */
    public function store(CreatePayrollDetailRequest $request)
    {
        $input = $request->all();

        $payrollDetail = $this->getRepositoryObj()->create($input);
        if ($payrollDetail instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $payrollDetail->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/payrollDetails.singular')]));

        return redirect(route('hr.payrollDetails.index'));
    }

    /**
     * Display the specified PayrollDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payrollDetail = $this->getRepositoryObj()->find($id);

        if (empty($payrollDetail)) {
            Flash::error(__('models/payrollDetails.singular').' '.__('messages.not_found'));

            return redirect(route('hr.payrollDetails.index'));
        }

        return view('hr.payroll_details.show')->with('payrollDetail', $payrollDetail);
    }

    /**
     * Show the form for editing the specified PayrollDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payrollDetail = $this->getRepositoryObj()->find($id);

        if (empty($payrollDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollDetails.singular')]));

            return redirect(route('hr.payrollDetails.index'));
        }

        return view('hr.payroll_details.edit')->with('payrollDetail', $payrollDetail)->with($this->getOptionItems());
    }

    /**
     * Update the specified PayrollDetail in storage.
     *
     * @param  int              $id
     * @param UpdatePayrollDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayrollDetailRequest $request)
    {
        $payrollDetail = $this->getRepositoryObj()->find($id);

        if (empty($payrollDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollDetails.singular')]));

            return redirect(route('hr.payrollDetails.index'));
        }

        $payrollDetail = $this->getRepositoryObj()->update($request->all(), $id);
        if ($payrollDetail instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $payrollDetail->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/payrollDetails.singular')]));

        return redirect(route('hr.payrollDetails.index').'?payroll_id='.$payrollDetail->payroll_id);
    }

    /**
     * Remove the specified PayrollDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payrollDetail = $this->getRepositoryObj()->find($id);

        if (empty($payrollDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollDetails.singular')]));

            return redirect(route('hr.payrollDetails.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/payrollDetails.singular')]));

        return redirect(route('hr.payrollDetails.index'));
    }

    /**
     * Provide options item based on relationship model PayrollDetail from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {        
        return [
           
        ];
    }
}
