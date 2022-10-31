<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryGroupDataTable;

use App\Http\Requests\Hr\CreateSalaryGroupRequest;
use App\Http\Requests\Hr\UpdateSalaryGroupRequest;
use App\Repositories\Hr\SalaryGroupRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Hr\SalaryComponentRepository;
use Response;
use Exception;

class SalaryGroupController extends AppBaseController
{
    /** @var  SalaryGroupRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SalaryGroupRepository::class;
    }

    /**
     * Display a listing of the SalaryGroup.
     *
     * @param SalaryGroupDataTable $salaryGroupDataTable
     * @return Response
     */
    public function index(SalaryGroupDataTable $salaryGroupDataTable)
    {
        return $salaryGroupDataTable->render('hr.salary_groups.index');
    }

    /**
     * Show the form for creating a new SalaryGroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.salary_groups.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SalaryGroup in storage.
     *
     * @param CreateSalaryGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryGroupRequest $request)
    {
        $input = $request->all();

        $salaryGroup = $this->getRepositoryObj()->create($input);
        if ($salaryGroup instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryGroup->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/salaryGroups.singular')]));

        return redirect(route('hr.salaryGroups.index'));
    }

    /**
     * Display the specified SalaryGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salaryGroup = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroup)) {
            Flash::error(__('models/salaryGroups.singular').' '.__('messages.not_found'));

            return redirect(route('hr.salaryGroups.index'));
        }

        return view('hr.salary_groups.show')->with('salaryGroup', $salaryGroup);
    }

    /**
     * Show the form for editing the specified SalaryGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salaryGroup = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryGroups.singular')]));

            return redirect(route('hr.salaryGroups.index'));
        }

        return view('hr.salary_groups.edit')->with('salaryGroup', $salaryGroup)->with($this->getOptionItems());
    }

    /**
     * Update the specified SalaryGroup in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalaryGroupRequest $request)
    {
        $salaryGroup = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryGroups.singular')]));

            return redirect(route('hr.salaryGroups.index'));
        }

        $salaryGroup = $this->getRepositoryObj()->update($request->all(), $id);
        if ($salaryGroup instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryGroup->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryGroups.singular')]));

        return redirect(route('hr.salaryGroups.index'));
    }

    /**
     * Remove the specified SalaryGroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryGroup = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryGroups.singular')]));

            return redirect(route('hr.salaryGroups.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryGroups.singular')]));

        return redirect(route('hr.salaryGroups.index'));
    }

    /**
     * Provide options item based on relationship model SalaryGroup from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {   
        $salaryComponent = (new SalaryComponentRepository())->all()->groupBy('state');
        return [
            'components' => $salaryComponent
        ];
    }
}
