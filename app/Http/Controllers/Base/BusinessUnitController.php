<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\BusinessUnitDataTable;

use App\Http\Requests\Base\CreateBusinessUnitRequest;
use App\Http\Requests\Base\UpdateBusinessUnitRequest;
use App\Repositories\Base\BusinessUnitRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class BusinessUnitController extends AppBaseController
{
    /** @var  BusinessUnitRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = BusinessUnitRepository::class;
    }

    /**
     * Display a listing of the BusinessUnit.
     *
     * @param BusinessUnitDataTable $businessUnitDataTable
     * @return Response
     */
    public function index(BusinessUnitDataTable $businessUnitDataTable)
    {
        return $businessUnitDataTable->render('base.business_units.index');
    }

    /**
     * Show the form for creating a new BusinessUnit.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.business_units.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created BusinessUnit in storage.
     *
     * @param CreateBusinessUnitRequest $request
     *
     * @return Response
     */
    public function store(CreateBusinessUnitRequest $request)
    {
        $input = $request->all();

        $businessUnit = $this->getRepositoryObj()->create($input);
        if($businessUnit instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $businessUnit->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/businessUnits.singular')]));

        return redirect(route('base.businessUnits.index'));
    }

    /**
     * Display the specified BusinessUnit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $businessUnit = $this->getRepositoryObj()->find($id);

        if (empty($businessUnit)) {
            Flash::error(__('models/businessUnits.singular').' '.__('messages.not_found'));

            return redirect(route('base.businessUnits.index'));
        }

        return view('base.business_units.show')->with('businessUnit', $businessUnit);
    }

    /**
     * Show the form for editing the specified BusinessUnit.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $businessUnit = $this->getRepositoryObj()->find($id);

        if (empty($businessUnit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/businessUnits.singular')]));

            return redirect(route('base.businessUnits.index'));
        }
        
        return view('base.business_units.edit')->with('businessUnit', $businessUnit)->with($this->getOptionItems());
    }

    /**
     * Update the specified BusinessUnit in storage.
     *
     * @param  int              $id
     * @param UpdateBusinessUnitRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateBusinessUnitRequest $request)
    {
        $businessUnit = $this->getRepositoryObj()->find($id);

        if (empty($businessUnit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/businessUnits.singular')]));

            return redirect(route('base.businessUnits.index'));
        }

        $businessUnit = $this->getRepositoryObj()->update($request->all(), $id);
        if($businessUnit instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $businessUnit->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/businessUnits.singular')]));

        return redirect(route('base.businessUnits.index'));
    }

    /**
     * Remove the specified BusinessUnit from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $businessUnit = $this->getRepositoryObj()->find($id);

        if (empty($businessUnit)) {
            Flash::error(__('messages.not_found', ['model' => __('models/businessUnits.singular')]));

            return redirect(route('base.businessUnits.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/businessUnits.singular')]));

        return redirect(route('base.businessUnits.index'));
    }

    /**
     * Provide options item based on relationship model BusinessUnit from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        
        return [
                        
        ];
    }
}
