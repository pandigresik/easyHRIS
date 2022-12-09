<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\OvertimeDataTable;

use App\Http\Requests\Hr\CreateOvertimeRequest;
use App\Http\Requests\Hr\UpdateOvertimeRequest;
use App\Repositories\Hr\OvertimeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class OvertimeController extends AppBaseController
{
    /** @var  OvertimeRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = OvertimeRepository::class;
    }

    /**
     * Display a listing of the Overtime.
     *
     * @param OvertimeDataTable $overtimeDataTable
     * @return Response
     */
    public function index(OvertimeDataTable $overtimeDataTable)
    {
        return $overtimeDataTable->render('hr.overtimes.index');
    }

    /**
     * Show the form for creating a new Overtime.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.overtimes.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Overtime in storage.
     *
     * @param CreateOvertimeRequest $request
     *
     * @return Response
     */
    public function store(CreateOvertimeRequest $request)
    {
        $input = $request->all();

        $overtime = $this->getRepositoryObj()->create($input);
        if($overtime instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $overtime->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/overtimes.singular')]));

        return redirect(route('hr.overtimes.index'));
    }

    /**
     * Display the specified Overtime.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $overtime = $this->getRepositoryObj()->find($id);

        if (empty($overtime)) {
            Flash::error(__('models/overtimes.singular').' '.__('messages.not_found'));

            return redirect(route('hr.overtimes.index'));
        }

        return view('hr.overtimes.show')->with('overtime', $overtime);
    }

    /**
     * Show the form for editing the specified Overtime.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $overtime = $this->getRepositoryObj()->with(['employee'])->find($id);

        if (empty($overtime)) {
            Flash::error(__('messages.not_found', ['model' => __('models/overtimes.singular')]));

            return redirect(route('hr.overtimes.index'));
        }
        $optionItems = $this->getOptionItems();
         
        $optionItems['employeeItems'] = [$overtime->employee_id => $overtime->employee->full_name .'('.$overtime->employee->code.')']; 
        return view('hr.overtimes.edit')->with('overtime', $overtime)->with($optionItems);
    }

    /**
     * Update the specified Overtime in storage.
     *
     * @param  int              $id
     * @param UpdateOvertimeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOvertimeRequest $request)
    {
        $overtime = $this->getRepositoryObj()->find($id);

        if (empty($overtime)) {
            Flash::error(__('messages.not_found', ['model' => __('models/overtimes.singular')]));

            return redirect(route('hr.overtimes.index'));
        }
        $input = $request->all();        
        $overtime = $this->getRepositoryObj()->update($input, $id);
        if($overtime instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $overtime->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/overtimes.singular')]));

        return redirect(route('hr.overtimes.index'));
    }

    /**
     * Remove the specified Overtime from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $overtime = $this->getRepositoryObj()->find($id);

        if (empty($overtime)) {
            Flash::error(__('messages.not_found', ['model' => __('models/overtimes.singular')]));

            return redirect(route('hr.overtimes.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/overtimes.singular')]));

        return redirect(route('hr.overtimes.index'));
    }

    /**
     * Provide options item based on relationship model Overtime from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        // $shiftment = new ShiftmentRepository();
        
        return [
            // 'shiftmentItems' => ['' => __('crud.option.shiftment_placeholder')] + $shiftment->pluck(),
            'shiftmentItems' => [],
            'employeeItems' => []           
        ];
    }
}
