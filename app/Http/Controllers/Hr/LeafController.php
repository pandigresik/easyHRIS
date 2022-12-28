<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\LeafDataTable;

use App\Http\Requests\Hr\CreateLeafRequest;
use App\Http\Requests\Hr\UpdateLeafRequest;
use App\Repositories\Hr\LeafRepository;
use App\Repositories\Hr\AbsentReasonRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class LeafController extends AppBaseController
{
    /** @var  LeafRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = LeafRepository::class;
    }

    /**
     * Display a listing of the Leaf.
     *
     * @param LeafDataTable $leafDataTable
     * @return Response
     */
    public function index(LeafDataTable $leafDataTable)
    {
        return $leafDataTable->render('hr.leaves.index');
    }

    /**
     * Show the form for creating a new Leaf.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.leaves.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Leaf in storage.
     *
     * @param CreateLeafRequest $request
     *
     * @return Response
     */
    public function store(CreateLeafRequest $request)
    {
        $input = $request->all();

        $leaf = $this->getRepositoryObj()->create($input);
        if($leaf instanceof Exception){
            $input['leave_start'] = localFormatDateTime($input['leave_start']);
            $input['leave_end'] = localFormatDateTime($input['leave_end']);
            return redirect()->back()->withInput($input)->withErrors(['error', $leaf->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/leaves.singular')]));

        return redirect(route('hr.leaves.index'));
    }

    /**
     * Display the specified Leaf.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $leaf = $this->getRepositoryObj()->find($id);

        if (empty($leaf)) {
            Flash::error(__('models/leaves.singular').' '.__('messages.not_found'));

            return redirect(route('hr.leaves.index'));
        }

        return view('hr.leaves.show')->with('leaf', $leaf);
    }

    /**
     * Show the form for editing the specified Leaf.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $leaf = $this->getRepositoryObj()->with(['employee'])->find($id);

        if (empty($leaf)) {
            Flash::error(__('messages.not_found', ['model' => __('models/leaves.singular')]));

            return redirect(route('hr.leaves.index'));
        }
        $optionItems = $this->getOptionItems();
         
        $optionItems['employeeItems'] = [$leaf->employee_id => $leaf->employee->full_name .'('.$leaf->employee->code.')']; 
        return view('hr.leaves.edit')->with('leaf', $leaf)->with($optionItems);
    }

    /**
     * Update the specified Leaf in storage.
     *
     * @param  int              $id
     * @param UpdateLeafRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeafRequest $request)
    {
        $leaf = $this->getRepositoryObj()->find($id);

        if (empty($leaf)) {
            Flash::error(__('messages.not_found', ['model' => __('models/leaves.singular')]));

            return redirect(route('hr.leaves.index'));
        }

        $leaf = $this->getRepositoryObj()->update($request->all(), $id);
        if($leaf instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $leaf->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/leaves.singular')]));

        return redirect(route('hr.leaves.index'));
    }

    /**
     * Remove the specified Leaf from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $leaf = $this->getRepositoryObj()->find($id);

        if (empty($leaf)) {
            Flash::error(__('messages.not_found', ['model' => __('models/leaves.singular')]));

            return redirect(route('hr.leaves.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/leaves.singular')]));

        return redirect(route('hr.leaves.index'));
    }

    /**
     * Provide options item based on relationship model Leaf from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $absentReason = new AbsentReasonRepository();
        
        return [
            'reasonItems' => ['' => __('crud.option.absentReason_placeholder')] + $absentReason->pluck(),
            'employeeItems' => []
        ];
    }
}
