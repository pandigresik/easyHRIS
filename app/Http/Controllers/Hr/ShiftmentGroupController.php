<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\ShiftmentGroupDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateShiftmentGroupRequest;
use App\Http\Requests\Hr\UpdateShiftmentGroupRequest;
use App\Repositories\Hr\ShiftmentGroupRepository;
use App\Repositories\Hr\CompanyRepository;
use App\Repositories\Hr\ShiftmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class ShiftmentGroupController extends AppBaseController
{
    /** @var  ShiftmentGroupRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = ShiftmentGroupRepository::class;
    }

    /**
     * Display a listing of the ShiftmentGroup.
     *
     * @param ShiftmentGroupDataTable $shiftmentGroupDataTable
     * @return Response
     */
    public function index(ShiftmentGroupDataTable $shiftmentGroupDataTable)
    {
        return $shiftmentGroupDataTable->render('hr.shiftment_groups.index');
    }

    /**
     * Show the form for creating a new ShiftmentGroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.shiftment_groups.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created ShiftmentGroup in storage.
     *
     * @param CreateShiftmentGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateShiftmentGroupRequest $request)
    {
        $input = $request->all();

        $shiftmentGroup = $this->getRepositoryObj()->create($input);
        if($shiftmentGroup instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $shiftmentGroup->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/shiftmentGroups.singular')]));

        return redirect(route('hr.shiftmentGroups.index'));
    }

    /**
     * Display the specified ShiftmentGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $shiftmentGroup = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroup)) {
            Flash::error(__('models/shiftmentGroups.singular').' '.__('messages.not_found'));

            return redirect(route('hr.shiftmentGroups.index'));
        }

        return view('hr.shiftment_groups.show')->with('shiftmentGroup', $shiftmentGroup);
    }

    /**
     * Show the form for editing the specified ShiftmentGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $shiftmentGroup = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentGroups.singular')]));

            return redirect(route('hr.shiftmentGroups.index'));
        }
        
        return view('hr.shiftment_groups.edit')->with('shiftmentGroup', $shiftmentGroup)->with($this->getOptionItems());
    }

    /**
     * Update the specified ShiftmentGroup in storage.
     *
     * @param  int              $id
     * @param UpdateShiftmentGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateShiftmentGroupRequest $request)
    {
        $shiftmentGroup = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentGroups.singular')]));

            return redirect(route('hr.shiftmentGroups.index'));
        }

        $shiftmentGroup = $this->getRepositoryObj()->update($request->all(), $id);
        if($shiftmentGroup instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $shiftmentGroup->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/shiftmentGroups.singular')]));

        return redirect(route('hr.shiftmentGroups.index'));
    }

    /**
     * Remove the specified ShiftmentGroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $shiftmentGroup = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentGroups.singular')]));

            return redirect(route('hr.shiftmentGroups.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/shiftmentGroups.singular')]));

        return redirect(route('hr.shiftmentGroups.index'));
    }

    /**
     * Provide options item based on relationship model ShiftmentGroup from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $company = new CompanyRepository();
        $shiftment = new ShiftmentRepository();
        return [
            'companyItems' => ['' => __('crud.option.company_placeholder')] + $company->pluck(),
            'shiftmentItems' => ['' => __('crud.option.shiftment_placeholder')] + $shiftment->pluck()            
        ];
    }
}
