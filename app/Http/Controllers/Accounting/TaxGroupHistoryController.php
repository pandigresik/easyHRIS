<?php

namespace App\Http\Controllers\Accounting;

use App\DataTables\Accounting\TaxGroupHistoryDataTable;
use App\Http\Requests\Accounting;
use App\Http\Requests\Accounting\CreateTaxGroupHistoryRequest;
use App\Http\Requests\Accounting\UpdateTaxGroupHistoryRequest;
use App\Repositories\Accounting\TaxGroupHistoryRepository;
use App\Repositories\Accounting\EmployeeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class TaxGroupHistoryController extends AppBaseController
{
    /** @var  TaxGroupHistoryRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = TaxGroupHistoryRepository::class;
    }

    /**
     * Display a listing of the TaxGroupHistory.
     *
     * @param TaxGroupHistoryDataTable $taxGroupHistoryDataTable
     * @return Response
     */
    public function index(TaxGroupHistoryDataTable $taxGroupHistoryDataTable)
    {
        return $taxGroupHistoryDataTable->render('accounting.tax_group_histories.index');
    }

    /**
     * Show the form for creating a new TaxGroupHistory.
     *
     * @return Response
     */
    public function create()
    {
        return view('accounting.tax_group_histories.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created TaxGroupHistory in storage.
     *
     * @param CreateTaxGroupHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateTaxGroupHistoryRequest $request)
    {
        $input = $request->all();

        $taxGroupHistory = $this->getRepositoryObj()->create($input);
        if($taxGroupHistory instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $taxGroupHistory->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/taxGroupHistories.singular')]));

        return redirect(route('accounting.taxGroupHistories.index'));
    }

    /**
     * Display the specified TaxGroupHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $taxGroupHistory = $this->getRepositoryObj()->find($id);

        if (empty($taxGroupHistory)) {
            Flash::error(__('models/taxGroupHistories.singular').' '.__('messages.not_found'));

            return redirect(route('accounting.taxGroupHistories.index'));
        }

        return view('accounting.tax_group_histories.show')->with('taxGroupHistory', $taxGroupHistory);
    }

    /**
     * Show the form for editing the specified TaxGroupHistory.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $taxGroupHistory = $this->getRepositoryObj()->find($id);

        if (empty($taxGroupHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/taxGroupHistories.singular')]));

            return redirect(route('accounting.taxGroupHistories.index'));
        }
        
        return view('accounting.tax_group_histories.edit')->with('taxGroupHistory', $taxGroupHistory)->with($this->getOptionItems());
    }

    /**
     * Update the specified TaxGroupHistory in storage.
     *
     * @param  int              $id
     * @param UpdateTaxGroupHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTaxGroupHistoryRequest $request)
    {
        $taxGroupHistory = $this->getRepositoryObj()->find($id);

        if (empty($taxGroupHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/taxGroupHistories.singular')]));

            return redirect(route('accounting.taxGroupHistories.index'));
        }

        $taxGroupHistory = $this->getRepositoryObj()->update($request->all(), $id);
        if($taxGroupHistory instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $taxGroupHistory->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/taxGroupHistories.singular')]));

        return redirect(route('accounting.taxGroupHistories.index'));
    }

    /**
     * Remove the specified TaxGroupHistory from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $taxGroupHistory = $this->getRepositoryObj()->find($id);

        if (empty($taxGroupHistory)) {
            Flash::error(__('messages.not_found', ['model' => __('models/taxGroupHistories.singular')]));

            return redirect(route('accounting.taxGroupHistories.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/taxGroupHistories.singular')]));

        return redirect(route('accounting.taxGroupHistories.index'));
    }

    /**
     * Provide options item based on relationship model TaxGroupHistory from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $employee = new EmployeeRepository();
        return [
            'employeeItems' => ['' => __('crud.option.employee_placeholder')] + $employee->pluck()            
        ];
    }
}
