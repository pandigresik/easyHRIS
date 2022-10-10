<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\PayrollDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreatePayrollRequest;
use App\Http\Requests\Hr\UpdatePayrollRequest;
use App\Repositories\Hr\PayrollRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\PayrollPeriodRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class PayrollController extends AppBaseController
{
    /** @var  PayrollRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = PayrollRepository::class;
    }

    /**
     * Display a listing of the Payroll.
     *
     * @param PayrollDataTable $payrollDataTable
     * @return Response
     */
    public function index(PayrollDataTable $payrollDataTable)
    {
        return $payrollDataTable->render('hr.payrolls.index');
    }

    /**
     * Show the form for creating a new Payroll.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.payrolls.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Payroll in storage.
     *
     * @param CreatePayrollRequest $request
     *
     * @return Response
     */
    public function store(CreatePayrollRequest $request)
    {
        $input = $request->all();

        $payroll = $this->getRepositoryObj()->create($input);
        if($payroll instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $payroll->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/payrolls.singular')]));

        return redirect(route('hr.payrolls.index'));
    }

    /**
     * Display the specified Payroll.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payroll = $this->getRepositoryObj()->find($id);

        if (empty($payroll)) {
            Flash::error(__('models/payrolls.singular').' '.__('messages.not_found'));

            return redirect(route('hr.payrolls.index'));
        }

        return view('hr.payrolls.show')->with('payroll', $payroll);
    }

    /**
     * Show the form for editing the specified Payroll.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payroll = $this->getRepositoryObj()->find($id);

        if (empty($payroll)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrolls.singular')]));

            return redirect(route('hr.payrolls.index'));
        }
        
        return view('hr.payrolls.edit')->with('payroll', $payroll)->with($this->getOptionItems());
    }

    /**
     * Update the specified Payroll in storage.
     *
     * @param  int              $id
     * @param UpdatePayrollRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayrollRequest $request)
    {
        $payroll = $this->getRepositoryObj()->find($id);

        if (empty($payroll)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrolls.singular')]));

            return redirect(route('hr.payrolls.index'));
        }

        $payroll = $this->getRepositoryObj()->update($request->all(), $id);
        if($payroll instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $payroll->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/payrolls.singular')]));

        return redirect(route('hr.payrolls.index'));
    }

    /**
     * Remove the specified Payroll from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payroll = $this->getRepositoryObj()->find($id);

        if (empty($payroll)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrolls.singular')]));

            return redirect(route('hr.payrolls.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/payrolls.singular')]));

        return redirect(route('hr.payrolls.index'));
    }

    /**
     * Provide options item based on relationship model Payroll from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $employee = new EmployeeRepository();
        $payrollPeriod = new PayrollPeriodRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'payrollPeriodItems' => ['' => __('crud.option.payrollPeriod_placeholder')] + $payrollPeriod->pluck()            
        ];
    }
}
