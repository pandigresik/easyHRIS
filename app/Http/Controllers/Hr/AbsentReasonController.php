<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\AbsentReasonDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateAbsentReasonRequest;
use App\Http\Requests\Hr\UpdateAbsentReasonRequest;
use App\Repositories\Hr\AbsentReasonRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class AbsentReasonController extends AppBaseController
{
    /** @var  AbsentReasonRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = AbsentReasonRepository::class;
    }

    /**
     * Display a listing of the AbsentReason.
     *
     * @param AbsentReasonDataTable $absentReasonDataTable
     * @return Response
     */
    public function index(AbsentReasonDataTable $absentReasonDataTable)
    {
        return $absentReasonDataTable->render('hr.absent_reasons.index');
    }

    /**
     * Show the form for creating a new AbsentReason.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.absent_reasons.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created AbsentReason in storage.
     *
     * @param CreateAbsentReasonRequest $request
     *
     * @return Response
     */
    public function store(CreateAbsentReasonRequest $request)
    {
        $input = $request->all();

        $absentReason = $this->getRepositoryObj()->create($input);
        if($absentReason instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $absentReason->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/absentReasons.singular')]));

        return redirect(route('hr.absentReasons.index'));
    }

    /**
     * Display the specified AbsentReason.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $absentReason = $this->getRepositoryObj()->find($id);

        if (empty($absentReason)) {
            Flash::error(__('models/absentReasons.singular').' '.__('messages.not_found'));

            return redirect(route('hr.absentReasons.index'));
        }

        return view('hr.absent_reasons.show')->with('absentReason', $absentReason);
    }

    /**
     * Show the form for editing the specified AbsentReason.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $absentReason = $this->getRepositoryObj()->find($id);

        if (empty($absentReason)) {
            Flash::error(__('messages.not_found', ['model' => __('models/absentReasons.singular')]));

            return redirect(route('hr.absentReasons.index'));
        }
        
        return view('hr.absent_reasons.edit')->with('absentReason', $absentReason)->with($this->getOptionItems());
    }

    /**
     * Update the specified AbsentReason in storage.
     *
     * @param  int              $id
     * @param UpdateAbsentReasonRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAbsentReasonRequest $request)
    {
        $absentReason = $this->getRepositoryObj()->find($id);

        if (empty($absentReason)) {
            Flash::error(__('messages.not_found', ['model' => __('models/absentReasons.singular')]));

            return redirect(route('hr.absentReasons.index'));
        }

        $absentReason = $this->getRepositoryObj()->update($request->all(), $id);
        if($absentReason instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $absentReason->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/absentReasons.singular')]));

        return redirect(route('hr.absentReasons.index'));
    }

    /**
     * Remove the specified AbsentReason from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $absentReason = $this->getRepositoryObj()->find($id);

        if (empty($absentReason)) {
            Flash::error(__('messages.not_found', ['model' => __('models/absentReasons.singular')]));

            return redirect(route('hr.absentReasons.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/absentReasons.singular')]));

        return redirect(route('hr.absentReasons.index'));
    }

    /**
     * Provide options item based on relationship model AbsentReason from storage.         
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
