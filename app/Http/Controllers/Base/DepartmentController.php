<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\DepartmentDataTable;

use App\Http\Requests\Base\CreateDepartmentRequest;
use App\Http\Requests\Base\UpdateDepartmentRequest;
use App\Repositories\Base\DepartmentRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use App\Models\Base\Department;
use App\Traits\ChartOrgTrait;
use Response;
use Exception;

class DepartmentController extends AppBaseController
{
    use ChartOrgTrait;

    /** @var  DepartmentRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = DepartmentRepository::class;
    }

    /**
     * Display a listing of the Department.
     *
     * @param DepartmentDataTable $departmentDataTable
     * @return Response
     */
    public function index(DepartmentDataTable $departmentDataTable)
    {
        return $departmentDataTable->render('base.departments.index');
    }

    /**
     * Show the form for creating a new Department.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.departments.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Department in storage.
     *
     * @param CreateDepartmentRequest $request
     *
     * @return Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        $input = $request->all();

        $department = $this->getRepositoryObj()->create($input);
        if ($department instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $department->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/departments.singular')]));

        return redirect(route('base.departments.index'));
    }

    /**
     * Display the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $department = $this->getRepositoryObj()->find($id);

        if (empty($department)) {
            Flash::error(__('models/departments.singular').' '.__('messages.not_found'));

            return redirect(route('base.departments.index'));
        }

        return view('base.departments.show')->with('department', $department);
    }

    /**
     * Show the form for editing the specified Department.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $department = $this->getRepositoryObj()->find($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('base.departments.index'));
        }

        return view('base.departments.edit')->with('department', $department)->with($this->getOptionItems());
    }

    /**
     * Update the specified Department in storage.
     *
     * @param  int              $id
     * @param UpdateDepartmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateDepartmentRequest $request)
    {
        $department = $this->getRepositoryObj()->find($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('base.departments.index'));
        }

        $department = $this->getRepositoryObj()->update($request->all(), $id);
        if ($department instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $department->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/departments.singular')]));

        return redirect(route('base.departments.index'));
    }

    /**
     * Remove the specified Department from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $department = $this->getRepositoryObj()->find($id);

        if (empty($department)) {
            Flash::error(__('messages.not_found', ['model' => __('models/departments.singular')]));

            return redirect(route('base.departments.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/departments.singular')]));

        return redirect(route('base.departments.index'));
    }

    /**
     * Provide options item based on relationship model Department from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $parentItems = (new DepartmentRepository())->pluck();
        return [
            'parentItems' => ['' => 'Pilih '] + $parentItems
        ];
    }

    protected function getDataChart($id = null){
        return (new Department())->generateChartData($id);
    }
    
}
