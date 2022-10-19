<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryGroupDetailDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateSalaryGroupDetailRequest;
use App\Http\Requests\Hr\UpdateSalaryGroupDetailRequest;
use App\Repositories\Hr\SalaryGroupDetailRepository;
use App\Repositories\Hr\SalaryGroupRepository;
use App\Repositories\Hr\SalaryComponentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SalaryGroupDetailController extends AppBaseController
{
    /** @var  SalaryGroupDetailRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SalaryGroupDetailRepository::class;
    }

    /**
     * Display a listing of the SalaryGroupDetail.
     *
     * @param SalaryGroupDetailDataTable $salaryGroupDetailDataTable
     * @return Response
     */
    public function index(SalaryGroupDetailDataTable $salaryGroupDetailDataTable)
    {
        return $salaryGroupDetailDataTable->render('hr.salary_group_details.index');
    }

    /**
     * Show the form for creating a new SalaryGroupDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.salary_group_details.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SalaryGroupDetail in storage.
     *
     * @param CreateSalaryGroupDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryGroupDetailRequest $request)
    {
        $input = $request->all();

        $salaryGroupDetail = $this->getRepositoryObj()->create($input);
        if ($salaryGroupDetail instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryGroupDetail->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/salaryGroupDetails.singular')]));

        return redirect(route('hr.salaryGroupDetails.index'));
    }

    /**
     * Display the specified SalaryGroupDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salaryGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroupDetail)) {
            Flash::error(__('models/salaryGroupDetails.singular').' '.__('messages.not_found'));

            return redirect(route('hr.salaryGroupDetails.index'));
        }

        return view('hr.salary_group_details.show')->with('salaryGroupDetail', $salaryGroupDetail);
    }

    /**
     * Show the form for editing the specified SalaryGroupDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salaryGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroupDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryGroupDetails.singular')]));

            return redirect(route('hr.salaryGroupDetails.index'));
        }

        return view('hr.salary_group_details.edit')->with('salaryGroupDetail', $salaryGroupDetail)->with($this->getOptionItems());
    }

    /**
     * Update the specified SalaryGroupDetail in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryGroupDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalaryGroupDetailRequest $request)
    {
        $salaryGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroupDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryGroupDetails.singular')]));

            return redirect(route('hr.salaryGroupDetails.index'));
        }

        $salaryGroupDetail = $this->getRepositoryObj()->update($request->all(), $id);
        if ($salaryGroupDetail instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $salaryGroupDetail->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryGroupDetails.singular')]));

        return redirect(route('hr.salaryGroupDetails.index'));
    }

    /**
     * Remove the specified SalaryGroupDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryGroupDetail = $this->getRepositoryObj()->find($id);

        if (empty($salaryGroupDetail)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryGroupDetails.singular')]));

            return redirect(route('hr.salaryGroupDetails.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryGroupDetails.singular')]));

        return redirect(route('hr.salaryGroupDetails.index'));
    }

    /**
     * Provide options item based on relationship model SalaryGroupDetail from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $salaryGroup = new SalaryGroupRepository();
        $salaryComponent = new SalaryComponentRepository();
        return [
            'salaryGroupItems' => ['' => __('crud.option.salaryGroup_placeholder')] + $salaryGroup->pluck(),
            'componentItems' => ['' => __('crud.option.salaryComponent_placeholder')] + $salaryComponent->pluck()
        ];
    }
}
