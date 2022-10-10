<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\ContractDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateContractRequest;
use App\Http\Requests\Hr\UpdateContractRequest;
use App\Repositories\Hr\ContractRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class ContractController extends AppBaseController
{
    /** @var  ContractRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = ContractRepository::class;
    }

    /**
     * Display a listing of the Contract.
     *
     * @param ContractDataTable $contractDataTable
     * @return Response
     */
    public function index(ContractDataTable $contractDataTable)
    {
        return $contractDataTable->render('hr.contracts.index');
    }

    /**
     * Show the form for creating a new Contract.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.contracts.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Contract in storage.
     *
     * @param CreateContractRequest $request
     *
     * @return Response
     */
    public function store(CreateContractRequest $request)
    {
        $input = $request->all();

        $contract = $this->getRepositoryObj()->create($input);
        if($contract instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $contract->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/contracts.singular')]));

        return redirect(route('hr.contracts.index'));
    }

    /**
     * Display the specified Contract.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $contract = $this->getRepositoryObj()->find($id);

        if (empty($contract)) {
            Flash::error(__('models/contracts.singular').' '.__('messages.not_found'));

            return redirect(route('hr.contracts.index'));
        }

        return view('hr.contracts.show')->with('contract', $contract);
    }

    /**
     * Show the form for editing the specified Contract.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $contract = $this->getRepositoryObj()->find($id);

        if (empty($contract)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contracts.singular')]));

            return redirect(route('hr.contracts.index'));
        }
        
        return view('hr.contracts.edit')->with('contract', $contract)->with($this->getOptionItems());
    }

    /**
     * Update the specified Contract in storage.
     *
     * @param  int              $id
     * @param UpdateContractRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateContractRequest $request)
    {
        $contract = $this->getRepositoryObj()->find($id);

        if (empty($contract)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contracts.singular')]));

            return redirect(route('hr.contracts.index'));
        }

        $contract = $this->getRepositoryObj()->update($request->all(), $id);
        if($contract instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $contract->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/contracts.singular')]));

        return redirect(route('hr.contracts.index'));
    }

    /**
     * Remove the specified Contract from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $contract = $this->getRepositoryObj()->find($id);

        if (empty($contract)) {
            Flash::error(__('messages.not_found', ['model' => __('models/contracts.singular')]));

            return redirect(route('hr.contracts.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/contracts.singular')]));

        return redirect(route('hr.contracts.index'));
    }

    /**
     * Provide options item based on relationship model Contract from storage.         
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
