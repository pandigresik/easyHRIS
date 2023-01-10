<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\LeafApproveDataTable;

use App\Http\Requests\Hr\UpdateLeafApproveRequest;
use App\Repositories\Hr\LeafRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class LeaveApproveController extends AppBaseController
{
    /** @var  LeafRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = LeafRepository::class;
    }

    /**
     * Display a listing of the leaf.
     *
     * @param LeafApproveDataTable $leafApproveDataTable
     * @return Response
     */
    public function index(LeafApproveDataTable $leafApproveDataTable)
    {
        $createdBy = request('created_by');
        return $leafApproveDataTable->setCreatedRequest($createdBy)->render('hr.leave_approves.index');
    }

    
    /**
     * Update the specified leaf in storage.
     *
     * @param  int              $id
     * @param UpdateleafRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeafApproveRequest $request)
    {        
        $leaf = $this->getRepositoryObj()->approveReject($request->all());
        if($leaf instanceof Exception){            
            return redirect()->back()->withInput()->withErrors(['error', $leaf->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/leaves.singular')]));

        return redirect(route('home'));
    }
}
