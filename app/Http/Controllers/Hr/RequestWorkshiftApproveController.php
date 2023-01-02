<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\RequestWorkshiftApproveDataTable;
use App\Http\Requests\Hr\UpdateRequestWorkshiftApproveRequest;
use App\Repositories\Hr\RequestWorkshiftRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class RequestWorkshiftApproveController extends AppBaseController
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
    public function index(RequestWorkshiftApproveDataTable $requestWorkshiftDataTable)
    {
        $createdBy = request('created_by');
        return $requestWorkshiftDataTable->setCreatedRequest($createdBy)->render('hr.request_workshift_approves.index');
    }    

    /**
     * Update the specified RequestWorkshift in storage.
     *
     * @param  int              $id
     * @param UpdateRequestWorkshiftApproveRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRequestWorkshiftApproveRequest $request)
    {        
        $requestWorkshift = $this->getRepositoryObj()->approveReject($request->all());
        if($requestWorkshift instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $requestWorkshift->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/requestWorkshifts.singular')]));

        return redirect(route('home'));
    }
}
