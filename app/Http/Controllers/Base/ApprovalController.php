<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\ApprovalDataTable;
use App\Http\Requests\Base;
use App\Http\Requests\Base\CreateApprovalRequest;
use App\Http\Requests\Base\UpdateApprovalRequest;
use App\Repositories\Base\ApprovalRepository;
use App\Repositories\Base\UserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class ApprovalController extends AppBaseController
{
    /** @var  ApprovalRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = ApprovalRepository::class;
    }

    /**
     * Display a listing of the Approval.
     *
     * @param ApprovalDataTable $approvalDataTable
     * @return Response
     */
    public function index(ApprovalDataTable $approvalDataTable)
    {
        return $approvalDataTable->render('base.approvals.index');
    }

    /**
     * Show the form for creating a new Approval.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.approvals.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Approval in storage.
     *
     * @param CreateApprovalRequest $request
     *
     * @return Response
     */
    public function store(CreateApprovalRequest $request)
    {
        $input = $request->all();

        $approval = $this->getRepositoryObj()->create($input);
        if($approval instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $approval->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/approvals.singular')]));

        return redirect(route('base.approvals.index'));
    }

    /**
     * Display the specified Approval.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $approval = $this->getRepositoryObj()->find($id);

        if (empty($approval)) {
            Flash::error(__('models/approvals.singular').' '.__('messages.not_found'));

            return redirect(route('base.approvals.index'));
        }

        return view('base.approvals.show')->with('approval', $approval);
    }

    /**
     * Show the form for editing the specified Approval.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $approval = $this->getRepositoryObj()->find($id);

        if (empty($approval)) {
            Flash::error(__('messages.not_found', ['model' => __('models/approvals.singular')]));

            return redirect(route('base.approvals.index'));
        }
        
        return view('base.approvals.edit')->with('approval', $approval)->with($this->getOptionItems());
    }

    /**
     * Update the specified Approval in storage.
     *
     * @param  int              $id
     * @param UpdateApprovalRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateApprovalRequest $request)
    {
        $approval = $this->getRepositoryObj()->find($id);

        if (empty($approval)) {
            Flash::error(__('messages.not_found', ['model' => __('models/approvals.singular')]));

            return redirect(route('base.approvals.index'));
        }

        $approval = $this->getRepositoryObj()->update($request->all(), $id);
        if($approval instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $approval->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/approvals.singular')]));

        return redirect(route('base.approvals.index'));
    }

    /**
     * Remove the specified Approval from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $approval = $this->getRepositoryObj()->find($id);

        if (empty($approval)) {
            Flash::error(__('messages.not_found', ['model' => __('models/approvals.singular')]));

            return redirect(route('base.approvals.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/approvals.singular')]));

        return redirect(route('base.approvals.index'));
    }

    /**
     * Provide options item based on relationship model Approval from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $user = new UserRepository();
        return [
            'userItems' => ['' => __('crud.option.user_placeholder')] + $user->pluck()            
        ];
    }
}
