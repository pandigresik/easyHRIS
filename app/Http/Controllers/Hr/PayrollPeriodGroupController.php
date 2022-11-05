<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\PayrollPeriodGroupDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreatePayrollPeriodGroupRequest;
use App\Http\Requests\Hr\UpdatePayrollPeriodGroupRequest;
use App\Repositories\Hr\PayrollPeriodGroupRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\PayrollPeriodGroup;
use Response;
use Exception;

class PayrollPeriodGroupController extends AppBaseController
{
    /** @var  PayrollPeriodGroupRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = PayrollPeriodGroupRepository::class;
    }

    /**
     * Display a listing of the PayrollPeriodGroup.
     *
     * @param PayrollPeriodGroupDataTable $payrollPeriodGroupDataTable
     * @return Response
     */
    public function index(PayrollPeriodGroupDataTable $payrollPeriodGroupDataTable)
    {
        return $payrollPeriodGroupDataTable->render('hr.payroll_period_groups.index');
    }

    /**
     * Show the form for creating a new PayrollPeriodGroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.payroll_period_groups.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created PayrollPeriodGroup in storage.
     *
     * @param CreatePayrollPeriodGroupRequest $request
     *
     * @return Response
     */
    public function store(CreatePayrollPeriodGroupRequest $request)
    {
        $input = $request->all();

        $payrollPeriodGroup = $this->getRepositoryObj()->create($input);
        if($payrollPeriodGroup instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $payrollPeriodGroup->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/payrollPeriodGroups.singular')]));

        return redirect(route('hr.payrollPeriodGroups.index'));
    }

    /**
     * Display the specified PayrollPeriodGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $payrollPeriodGroup = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriodGroup)) {
            Flash::error(__('models/payrollPeriodGroups.singular').' '.__('messages.not_found'));

            return redirect(route('hr.payrollPeriodGroups.index'));
        }

        return view('hr.payroll_period_groups.show')->with('payrollPeriodGroup', $payrollPeriodGroup);
    }

    /**
     * Show the form for editing the specified PayrollPeriodGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $payrollPeriodGroup = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriodGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriodGroups.singular')]));

            return redirect(route('hr.payrollPeriodGroups.index'));
        }
        
        return view('hr.payroll_period_groups.edit')->with('payrollPeriodGroup', $payrollPeriodGroup)->with($this->getOptionItems());
    }

    /**
     * Update the specified PayrollPeriodGroup in storage.
     *
     * @param  int              $id
     * @param UpdatePayrollPeriodGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePayrollPeriodGroupRequest $request)
    {
        $payrollPeriodGroup = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriodGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriodGroups.singular')]));

            return redirect(route('hr.payrollPeriodGroups.index'));
        }

        $payrollPeriodGroup = $this->getRepositoryObj()->update($request->all(), $id);
        if($payrollPeriodGroup instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $payrollPeriodGroup->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/payrollPeriodGroups.singular')]));

        return redirect(route('hr.payrollPeriodGroups.index'));
    }

    /**
     * Remove the specified PayrollPeriodGroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $payrollPeriodGroup = $this->getRepositoryObj()->find($id);

        if (empty($payrollPeriodGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/payrollPeriodGroups.singular')]));

            return redirect(route('hr.payrollPeriodGroups.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/payrollPeriodGroups.singular')]));

        return redirect(route('hr.payrollPeriodGroups.index'));
    }

    /**
     * Provide options item based on relationship model PayrollPeriodGroup from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        
        return [
          'periodItems' => PayrollPeriodGroup::PAYROLL_PERIOD              
        ];
    }
}
