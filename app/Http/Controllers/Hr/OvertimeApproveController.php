<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\OvertimeApproveDataTable;

use App\Http\Requests\Hr\UpdateOvertimeApproveRequest;
use App\Repositories\Hr\OvertimeRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class OvertimeApproveController extends AppBaseController
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
     * @param OvertimeApproveDataTable $overtimeApproveDataTable
     * @return Response
     */
    public function index(OvertimeApproveDataTable $overtimeApproveDataTable)
    {
        $createdBy = request('created_by');
        return $overtimeApproveDataTable->setCreatedRequest($createdBy)->render('hr.overtime_approves.index');
    }

    
    /**
     * Update the specified Overtime in storage.
     *
     * @param  int              $id
     * @param UpdateOvertimeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOvertimeApproveRequest $request)
    {        
        $overtime = $this->getRepositoryObj()->approveReject($request->all());
        if($overtime instanceof Exception){            
            return redirect()->back()->withInput()->withErrors(['error', $overtime->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/overtimes.singular')]));

        return redirect(route('home'));
    }
}
