<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SalaryComponentDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateSalaryComponentRequest;
use App\Http\Requests\Hr\UpdateSalaryComponentRequest;
use App\Repositories\Hr\SalaryComponentRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SalaryComponentController extends AppBaseController
{
    /** @var  SalaryComponentRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SalaryComponentRepository::class;
    }

    /**
     * Display a listing of the SalaryComponent.
     *
     * @param SalaryComponentDataTable $salaryComponentDataTable
     * @return Response
     */
    public function index(SalaryComponentDataTable $salaryComponentDataTable)
    {
        return $salaryComponentDataTable->render('hr.salary_components.index');
    }

    /**
     * Show the form for creating a new SalaryComponent.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.salary_components.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SalaryComponent in storage.
     *
     * @param CreateSalaryComponentRequest $request
     *
     * @return Response
     */
    public function store(CreateSalaryComponentRequest $request)
    {
        $input = $request->all();

        $salaryComponent = $this->getRepositoryObj()->create($input);
        if($salaryComponent instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $salaryComponent->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/salaryComponents.singular')]));

        return redirect(route('hr.salaryComponents.index'));
    }

    /**
     * Display the specified SalaryComponent.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $salaryComponent = $this->getRepositoryObj()->find($id);

        if (empty($salaryComponent)) {
            Flash::error(__('models/salaryComponents.singular').' '.__('messages.not_found'));

            return redirect(route('hr.salaryComponents.index'));
        }

        return view('hr.salary_components.show')->with('salaryComponent', $salaryComponent);
    }

    /**
     * Show the form for editing the specified SalaryComponent.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $salaryComponent = $this->getRepositoryObj()->find($id);

        if (empty($salaryComponent)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryComponents.singular')]));

            return redirect(route('hr.salaryComponents.index'));
        }
        
        return view('hr.salary_components.edit')->with('salaryComponent', $salaryComponent)->with($this->getOptionItems());
    }

    /**
     * Update the specified SalaryComponent in storage.
     *
     * @param  int              $id
     * @param UpdateSalaryComponentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSalaryComponentRequest $request)
    {
        $salaryComponent = $this->getRepositoryObj()->find($id);

        if (empty($salaryComponent)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryComponents.singular')]));

            return redirect(route('hr.salaryComponents.index'));
        }

        $salaryComponent = $this->getRepositoryObj()->update($request->all(), $id);
        if($salaryComponent instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $salaryComponent->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/salaryComponents.singular')]));

        return redirect(route('hr.salaryComponents.index'));
    }

    /**
     * Remove the specified SalaryComponent from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $salaryComponent = $this->getRepositoryObj()->find($id);

        if (empty($salaryComponent)) {
            Flash::error(__('messages.not_found', ['model' => __('models/salaryComponents.singular')]));

            return redirect(route('hr.salaryComponents.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/salaryComponents.singular')]));

        return redirect(route('hr.salaryComponents.index'));
    }

    /**
     * Provide options item based on relationship model SalaryComponent from storage.         
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
