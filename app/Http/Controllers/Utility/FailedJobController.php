<?php

namespace App\Http\Controllers\Utility;

use App\DataTables\Utility\FailedJobDataTable;
use App\Http\Requests\Utility;
use App\Http\Requests\Utility\CreateFailedJobRequest;
use App\Http\Requests\Utility\UpdateFailedJobRequest;
use App\Repositories\Utility\FailedJobRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;
use Illuminate\Support\Facades\Artisan;

class FailedJobController extends AppBaseController
{
    /** @var  FailedJobRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = FailedJobRepository::class;
    }

    /**
     * Display a listing of the FailedJob.
     *
     * @param FailedJobDataTable $failedJobDataTable
     * @return Response
     */
    public function index(FailedJobDataTable $failedJobDataTable)
    {
        return $failedJobDataTable->render('utility.failed_jobs.index');
    }

    /**
     * Show the form for creating a new FailedJob.
     *
     * @return Response
     */
    public function create()
    {
        return view('utility.failed_jobs.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created FailedJob in storage.
     *
     * @param CreateFailedJobRequest $request
     *
     * @return Response
     */
    public function store(CreateFailedJobRequest $request)
    {
        $input = $request->all();

        $failedJob = $this->getRepositoryObj()->create($input);
        if($failedJob instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $failedJob->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/failedJobs.singular')]));

        return redirect(route('utility.failedJobs.index'));
    }

    /**
     * Display the specified FailedJob.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $failedJob = $this->getRepositoryObj()->find($id);

        if (empty($failedJob)) {
            Flash::error(__('models/failedJobs.singular').' '.__('messages.not_found'));

            return redirect(route('utility.failedJobs.index'));
        }

        return view('utility.failed_jobs.show')->with('failedJob', $failedJob);
    }

    /**
     * Show the form for editing the specified FailedJob.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $failedJob = $this->getRepositoryObj()->find($id);

        if (empty($failedJob)) {
            Flash::error(__('messages.not_found', ['model' => __('models/failedJobs.singular')]));

            return redirect(route('utility.failedJobs.index'));
        }

        Artisan::call('queue:retry '.$id);
        return redirect(route('utility.failedJobs.index'));
        // return view('utility.failed_jobs.edit')->with('failedJob', $failedJob)->with($this->getOptionItems());
    }

    /**
     * Update the specified FailedJob in storage.
     *
     * @param  int              $id
     * @param UpdateFailedJobRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFailedJobRequest $request)
    {
        $failedJob = $this->getRepositoryObj()->find($id);

        if (empty($failedJob)) {
            Flash::error(__('messages.not_found', ['model' => __('models/failedJobs.singular')]));

            return redirect(route('utility.failedJobs.index'));
        }

        $failedJob = $this->getRepositoryObj()->update($request->all(), $id);
        if($failedJob instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $failedJob->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/failedJobs.singular')]));

        return redirect(route('utility.failedJobs.index'));
    }

    /**
     * Remove the specified FailedJob from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $failedJob = $this->getRepositoryObj()->find($id);

        if (empty($failedJob)) {
            Flash::error(__('messages.not_found', ['model' => __('models/failedJobs.singular')]));

            return redirect(route('utility.failedJobs.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/failedJobs.singular')]));

        return redirect(route('utility.failedJobs.index'));
    }

    /**
     * Provide options item based on relationship model FailedJob from storage.         
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
