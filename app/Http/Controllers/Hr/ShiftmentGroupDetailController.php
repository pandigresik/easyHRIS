<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\ShiftmentGroupDetailDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateShiftmentGroupDetailRequest;
use App\Http\Requests\Hr\UpdateShiftmentGroupDetailRequest;
use App\Repositories\Hr\ShiftmentGroupDetailRepository;
use App\Repositories\Hr\ShiftmentGroupRepository;
use App\Repositories\Hr\ShiftmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Hr\ShiftmentGroup;
use Response;
use Exception;

class ShiftmentGroupDetailController extends AppBaseController
{
    /** @var  ShiftmentGroupDetailRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = ShiftmentGroupDetailRepository::class;
    }

    /**
     * Display a listing of the ShiftmentGroupDetail.
     *
     * @param ShiftmentGroupDetailDataTable $shiftmentGroupDetailDataTable
     * @return Response
     */
    public function index(int $shiftmentGroup, ShiftmentGroupDetailDataTable $shiftmentGroupDetailDataTable)
    {
        return $shiftmentGroupDetailDataTable->setShiftmentGroup($shiftmentGroup)->render('hr.shiftment_group_details.index', ['shiftmentGroup' => $shiftmentGroup]);
    }

    /**
     * Show the form for creating a new ShiftmentGroupDetail.
     *
     * @return Response
     */
    public function create(int $shiftmentGroup)
    {
        return view('hr.shiftment_group_details.create')->with($this->getOptionItems())->with(['shiftmentGroup' => $shiftmentGroup]);
    }

    /**
     * Store a newly created ShiftmentGroupDetail in storage.
     *
     * @param CreateShiftmentGroupDetailRequest $request
     *
     * @return Response
     */
    public function store(int $shiftmentGroup, CreateShiftmentGroupDetailRequest $request)
    {
        $input = $request->all();
        $input['shiftment_group_id'] = $shiftmentGroup;
        $shiftmentGroupDetail = $this->getRepositoryObj()->create($input);
        if($shiftmentGroupDetail instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $shiftmentGroupDetail->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/shiftmentGroupDetails.singular')]));

        return redirect(route('hr.shiftmentGroups.details.index', $shiftmentGroup));
    }

    /**
     * Display the specified ShiftmentGroupDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show(int $shiftmentGroup, $id)
    {
        $shiftmentGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroupDetail)) {
            Flash::error(__('models/shiftmentGroupDetails.singular').' '.__('messages.not_found'));

            return redirect(route('hr.shiftmentGroupDetails.index', [$shiftmentGroup, $id]));
        }

        return view('hr.shiftment_group_details.show')->with('shiftmentGroupDetail', $shiftmentGroupDetail);
    }

    /**
     * Show the form for editing the specified ShiftmentGroupDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit(int $shiftmentGroup, $id)
    {
        $shiftmentGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroupDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentGroupDetails.singular')]));

            return redirect(route('hr.shiftmentGroups.details.index', $shiftmentGroup));
        }
        
        return view('hr.shiftment_group_details.edit')->with('shiftmentGroupDetail', $shiftmentGroupDetail)->with($this->getOptionItems());
    }

    /**
     * Update the specified ShiftmentGroupDetail in storage.
     *
     * @param  int              $id
     * @param UpdateShiftmentGroupDetailRequest $request
     *
     * @return Response
     */
    public function update(int $shiftmentGroup, $id, UpdateShiftmentGroupDetailRequest $request)
    {
        $shiftmentGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroupDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentGroupDetails.singular')]));

            return redirect(route('hr.shiftmentGroups.details.index', $shiftmentGroup));
        }

        $shiftmentGroupDetail = $this->getRepositoryObj()->update($request->all(), $id);
        if($shiftmentGroupDetail instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $shiftmentGroupDetail->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/shiftmentGroupDetails.singular')]));

        return redirect(route('hr.shiftmentGroups.details.index', $shiftmentGroup));
    }

    /**
     * Remove the specified ShiftmentGroupDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(int $shiftmentGroup, $id)
    {
        $shiftmentGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($shiftmentGroupDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/shiftmentGroupDetails.singular')]));

            return redirect(route('hr.shiftmentGroups.details.index', $shiftmentGroup));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/shiftmentGroupDetails.singular')]));

        return redirect(route('hr.shiftmentGroups.details.index', $shiftmentGroup));
    }

    /**
     * Provide options item based on relationship model ShiftmentGroupDetail from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $shiftmentGroup = new ShiftmentGroupRepository();
        $shiftment = new ShiftmentRepository();
        return [
            'shiftmentGroupItems' => ['' => __('crud.option.shiftmentGroup_placeholder')] + $shiftmentGroup->pluck(),
            'shiftmentItems' => ['' => __('crud.option.shiftment_placeholder')] + $shiftment->pluck()            
        ];
    }
}
