<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\RequestWorkshiftDataTable;
use App\Http\Requests\Hr\CreateRequestWorkshiftRequest;
use App\Http\Requests\Hr\UpdateRequestWorkshiftRequest;
use App\Repositories\Hr\RequestWorkshiftRepository;
use App\Repositories\Hr\ShiftmentRepository;
use App\Repositories\Hr\EmployeeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class RequestWorkshiftController extends AppBaseController
{
    /** @var  RequestWorkshiftRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = RequestWorkshiftRepository::class;
    }

    /**
     * Display a listing of the RequestWorkshift.
     *
     * @param RequestWorkshiftDataTable $requestWorkshiftDataTable
     * @return Response
     */
    public function index(RequestWorkshiftDataTable $requestWorkshiftDataTable)
    {
        return $requestWorkshiftDataTable->render('hr.request_workshifts.index');
    }

    /**
     * Show the form for creating a new RequestWorkshift.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.request_workshifts.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created RequestWorkshift in storage.
     *
     * @param CreateRequestWorkshiftRequest $request
     *
     * @return Response
     */
    public function store(CreateRequestWorkshiftRequest $request)
    {
        $input = $request->all();

        $requestWorkshift = $this->getRepositoryObj()->create($input);
        if($requestWorkshift instanceof Exception){
            $workDate = explode(' - ',$input['work_date']);            
            $input['work_date'] = localFormatDate($workDate[0]).' - '.localFormatDate($workDate[1]);            
            return redirect()->back()->withInput($input)->withErrors(['error', $requestWorkshift->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/requestWorkshifts.singular')]));

        return redirect(route('hr.requestWorkshifts.index'));
    }

    /**
     * Display the specified RequestWorkshift.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $requestWorkshift = $this->getRepositoryObj()->find($id);

        if (empty($requestWorkshift)) {
            Flash::error(__('models/requestWorkshifts.singular').' '.__('messages.not_found'));

            return redirect(route('hr.requestWorkshifts.index'));
        }

        return view('hr.request_workshifts.show')->with('requestWorkshift', $requestWorkshift);
    }

    /**
     * Show the form for editing the specified RequestWorkshift.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $requestWorkshift = $this->getRepositoryObj()->find($id);

        if (empty($requestWorkshift)) {
            Flash::error(__('messages.not_found', ['model' => __('models/requestWorkshifts.singular')]));

            return redirect(route('hr.requestWorkshifts.index'));
        }

        $optionItems = $this->getOptionItems();
        $optionItems['employeeItems'] = [$requestWorkshift->employee_id => $requestWorkshift->employee->full_name .'('.$requestWorkshift->employee->code.')']; 
        return view('hr.request_workshifts.edit')->with('requestWorkshift', $requestWorkshift)->with($optionItems);
    }

    /**
     * Update the specified RequestWorkshift in storage.
     *
     * @param  int              $id
     * @param UpdateRequestWorkshiftRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestWorkshiftRequest $request)
    {
        $requestWorkshift = $this->getRepositoryObj()->find($id);

        if (empty($requestWorkshift)) {
            Flash::error(__('messages.not_found', ['model' => __('models/requestWorkshifts.singular')]));

            return redirect(route('hr.requestWorkshifts.index'));
        }

        $requestWorkshift = $this->getRepositoryObj()->update($request->all(), $id);
        if($requestWorkshift instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $requestWorkshift->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/requestWorkshifts.singular')]));

        return redirect(route('hr.requestWorkshifts.index'));
    }

    /**
     * Remove the specified RequestWorkshift from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $requestWorkshift = $this->getRepositoryObj()->find($id);

        if (empty($requestWorkshift)) {
            Flash::error(__('messages.not_found', ['model' => __('models/requestWorkshifts.singular')]));

            return redirect(route('hr.requestWorkshifts.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/requestWorkshifts.singular')]));

        return redirect(route('hr.requestWorkshifts.index'));
    }

    /**
     * Provide options item based on relationship model RequestWorkshift from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $shiftment = new ShiftmentRepository();
        return [
            'shiftmentItems' => ['' => __('crud.option.shiftment_placeholder')] + $shiftment->pluck(),
            'employeeItems' => [],                   
        ];
    }
}
