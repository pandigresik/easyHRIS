<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\GroupingPayrollEntityDataTable;
use App\Http\Requests\Hr\CreateGroupingPayrollEntityRequest;
use App\Http\Requests\Hr\UpdateGroupingPayrollEntityRequest;
use App\Repositories\Hr\GroupingPayrollEntityRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class GroupingPayrollEntityController extends AppBaseController
{
    /** @var  GroupingPayrollEntityRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = GroupingPayrollEntityRepository::class;
    }

    /**
     * Display a listing of the GroupingPayrollEntity.
     *
     * @param GroupingPayrollEntityDataTable $groupingPayrollEntityDataTable
     * @return Response
     */
    public function index(GroupingPayrollEntityDataTable $groupingPayrollEntityDataTable)
    {
        return $groupingPayrollEntityDataTable->render('hr.grouping_payroll_entities.index');
    }

    /**
     * Show the form for creating a new GroupingPayrollEntity.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.grouping_payroll_entities.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created GroupingPayrollEntity in storage.
     *
     * @param CreateGroupingPayrollEntityRequest $request
     *
     * @return Response
     */
    public function store(CreateGroupingPayrollEntityRequest $request)
    {
        $input = $request->all();

        $groupingPayrollEntity = $this->getRepositoryObj()->create($input);
        if($groupingPayrollEntity instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $groupingPayrollEntity->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/groupingPayrollEntities.singular')]));

        return redirect(route('hr.groupingPayrollEntities.index'));
    }

    /**
     * Display the specified GroupingPayrollEntity.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $groupingPayrollEntity = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEntity)) {
            Flash::error(__('models/groupingPayrollEntities.singular').' '.__('messages.not_found'));

            return redirect(route('hr.groupingPayrollEntities.index'));
        }

        return view('hr.grouping_payroll_entities.show')->with('groupingPayrollEntity', $groupingPayrollEntity);
    }

    /**
     * Show the form for editing the specified GroupingPayrollEntity.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $groupingPayrollEntity = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEntity)) {
            Flash::error(__('messages.not_found', ['model' => __('models/groupingPayrollEntities.singular')]));

            return redirect(route('hr.groupingPayrollEntities.index'));
        }
        
        return view('hr.grouping_payroll_entities.edit')->with('groupingPayrollEntity', $groupingPayrollEntity)->with($this->getOptionItems());
    }

    /**
     * Update the specified GroupingPayrollEntity in storage.
     *
     * @param  int              $id
     * @param UpdateGroupingPayrollEntityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateGroupingPayrollEntityRequest $request)
    {
        $groupingPayrollEntity = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEntity)) {
            Flash::error(__('messages.not_found', ['model' => __('models/groupingPayrollEntities.singular')]));

            return redirect(route('hr.groupingPayrollEntities.index'));
        }

        $groupingPayrollEntity = $this->getRepositoryObj()->update($request->all(), $id);
        if($groupingPayrollEntity instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $groupingPayrollEntity->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/groupingPayrollEntities.singular')]));

        return redirect(route('hr.groupingPayrollEntities.index'));
    }

    /**
     * Remove the specified GroupingPayrollEntity from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $groupingPayrollEntity = $this->getRepositoryObj()->find($id);

        if (empty($groupingPayrollEntity)) {
            Flash::error(__('messages.not_found', ['model' => __('models/groupingPayrollEntities.singular')]));

            return redirect(route('hr.groupingPayrollEntities.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/groupingPayrollEntities.singular')]));

        return redirect(route('hr.groupingPayrollEntities.index'));
    }

    /**
     * Provide options item based on relationship model GroupingPayrollEntity from storage.         
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
