<?php

namespace App\Http\Controllers\Accounting;

use App\DataTables\Accounting\TaxDataTable;
use App\Http\Requests\Accounting;
use App\Http\Requests\Accounting\CreateTaxRequest;
use App\Http\Requests\Accounting\UpdateTaxRequest;
use App\Repositories\Accounting\TaxRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\PayrollPeriodRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\PayrollPeriod;
use Response;
use Exception;

class TaxController extends AppBaseController
{
    /** @var  TaxRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = TaxRepository::class;
    }

    /**
     * Display a listing of the Tax.
     *
     * @param TaxDataTable $taxDataTable
     * @return Response
     */
    public function index(TaxDataTable $taxDataTable)
    {
        return $taxDataTable->render('accounting.taxes.index');
    }

    /**
     * Show the form for creating a new Tax.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounting.taxes.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Tax in storage.
     *
     * @param CreateTaxRequest $request
     *
     * @return Response
     */
    public function store(CreateTaxRequest $request)
    {
        $input = $request->all();

        $tax = $this->getRepositoryObj()->create($input);
        if ($tax instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $tax->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/taxes.singular')]));

        return redirect(route('accounting.taxes.index'));
    }

    /**
     * Display the specified Tax.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $tax = $this->getRepositoryObj()->find($id);

        if (empty($tax)) {
            Flash::error(__('models/taxes.singular').' '.__('messages.not_found'));

            return redirect(route('accounting.taxes.index'));
        }

        return view('accounting.taxes.show')->with('tax', $tax);
    }

    /**
     * Show the form for editing the specified Tax.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $tax = $this->getRepositoryObj()->find($id);

        if (empty($tax)) {
            Flash::error(__('messages.not_found', ['model' => __('models/taxes.singular')]));

            return redirect(route('accounting.taxes.index'));
        }

        return view('accounting.taxes.edit')->with('tax', $tax)->with($this->getOptionItems());
    }

    /**
     * Update the specified Tax in storage.
     *
     * @param  int              $id
     * @param UpdateTaxRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaxRequest $request)
    {
        $tax = $this->getRepositoryObj()->find($id);

        if (empty($tax)) {
            Flash::error(__('messages.not_found', ['model' => __('models/taxes.singular')]));

            return redirect(route('accounting.taxes.index'));
        }

        $tax = $this->getRepositoryObj()->update($request->all(), $id);
        if ($tax instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $tax->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/taxes.singular')]));

        return redirect(route('accounting.taxes.index'));
    }

    /**
     * Remove the specified Tax from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $tax = $this->getRepositoryObj()->find($id);

        if (empty($tax)) {
            Flash::error(__('messages.not_found', ['model' => __('models/taxes.singular')]));

            return redirect(route('accounting.taxes.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/taxes.singular')]));

        return redirect(route('accounting.taxes.index'));
    }

    /**
     * Provide options item based on relationship model Tax from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $employee = new EmployeeRepository();
        $payrollPeriod = new PayrollPeriodRepository();

        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck(),
            'payrollPeriodItems' => ['' => __('crud.option.payrollPeriod_placeholder')] + $payrollPeriod->pluck()
        ];
    }
}
