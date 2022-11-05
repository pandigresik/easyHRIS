<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\RitaseDriverDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateRitaseDriverRequest;
use App\Http\Requests\Hr\UpdateRitaseDriverRequest;
use App\Repositories\Hr\RitaseDriverRepository;
use App\Repositories\Hr\EmployeeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class RitaseDriverController extends AppBaseController
{
    /** @var  RitaseDriverRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = RitaseDriverRepository::class;
    }

    /**
     * Display a listing of the RitaseDriver.
     *
     * @param RitaseDriverDataTable $ritaseDriverDataTable
     * @return Response
     */
    public function index(RitaseDriverDataTable $ritaseDriverDataTable)
    {
        return $ritaseDriverDataTable->render('hr.ritase_drivers.index');
    }

    /**
     * Show the form for creating a new RitaseDriver.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.ritase_drivers.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created RitaseDriver in storage.
     *
     * @param CreateRitaseDriverRequest $request
     *
     * @return Response
     */
    public function store(CreateRitaseDriverRequest $request)
    {
        $input = $request->all();

        $ritaseDriver = $this->getRepositoryObj()->create($input);
        if($ritaseDriver instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $ritaseDriver->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/ritaseDrivers.singular')]));

        return redirect(route('hr.ritaseDrivers.index'));
    }

    /**
     * Display the specified RitaseDriver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $ritaseDriver = $this->getRepositoryObj()->find($id);

        if (empty($ritaseDriver)) {
            Flash::error(__('models/ritaseDrivers.singular').' '.__('messages.not_found'));

            return redirect(route('hr.ritaseDrivers.index'));
        }

        return view('hr.ritase_drivers.show')->with('ritaseDriver', $ritaseDriver);
    }

    /**
     * Show the form for editing the specified RitaseDriver.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $ritaseDriver = $this->getRepositoryObj()->find($id);

        if (empty($ritaseDriver)) {
            Flash::error(__('messages.not_found', ['model' => __('models/ritaseDrivers.singular')]));

            return redirect(route('hr.ritaseDrivers.index'));
        }
        
        return view('hr.ritase_drivers.edit')->with('ritaseDriver', $ritaseDriver)->with($this->getOptionItems());
    }

    /**
     * Update the specified RitaseDriver in storage.
     *
     * @param  int              $id
     * @param UpdateRitaseDriverRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRitaseDriverRequest $request)
    {
        $ritaseDriver = $this->getRepositoryObj()->find($id);

        if (empty($ritaseDriver)) {
            Flash::error(__('messages.not_found', ['model' => __('models/ritaseDrivers.singular')]));

            return redirect(route('hr.ritaseDrivers.index'));
        }

        $ritaseDriver = $this->getRepositoryObj()->update($request->all(), $id);
        if($ritaseDriver instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $ritaseDriver->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/ritaseDrivers.singular')]));

        return redirect(route('hr.ritaseDrivers.index'));
    }

    /**
     * Remove the specified RitaseDriver from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $ritaseDriver = $this->getRepositoryObj()->find($id);

        if (empty($ritaseDriver)) {
            Flash::error(__('messages.not_found', ['model' => __('models/ritaseDrivers.singular')]));

            return redirect(route('hr.ritaseDrivers.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/ritaseDrivers.singular')]));

        return redirect(route('hr.ritaseDrivers.index'));
    }

    /**
     * Provide options item based on relationship model RitaseDriver from storage.         
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
