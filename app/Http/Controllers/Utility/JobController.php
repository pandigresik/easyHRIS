<?php

namespace App\Http\Controllers\Utility;

use App\DataTables\Utility\JobDataTable;
use App\Http\Requests\Utility;
use App\Http\Requests\Utility\CreateJobRequest;
use App\Http\Requests\Utility\UpdateJobRequest;
use App\Repositories\Utility\JobRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class JobController extends AppBaseController
{
    /** @var  JobRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = JobRepository::class;
    }

    /**
     * Display a listing of the Job.
     *
     * @param JobDataTable $jobDataTable
     * @return Response
     */
    public function index(JobDataTable $jobDataTable)
    {
        return $jobDataTable->render('utility.jobs.index');
    }

    /**
     * Show the form for creating a new Job.
     *
     * @return Response
     */
    public function create()
    {
        return view('utility.jobs.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Job in storage.
     *
     * @param CreateJobRequest $request
     *
     * @return Response
     */
    public function store(CreateJobRequest $request)
    {
        $input = $request->all();

        $job = $this->getRepositoryObj()->create($input);
        if($job instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $job->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/jobs.singular')]));

        return redirect(route('utility.jobs.index'));
    }

    /**
     * Display the specified Job.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $job = $this->getRepositoryObj()->find($id);

        if (empty($job)) {
            Flash::error(__('models/jobs.singular').' '.__('messages.not_found'));

            return redirect(route('utility.jobs.index'));
        }

        return view('utility.jobs.show')->with('job', $job);
    }

    /**
     * Show the form for editing the specified Job.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $job = $this->getRepositoryObj()->find($id);

        if (empty($job)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobs.singular')]));

            return redirect(route('utility.jobs.index'));
        }
        
        return view('utility.jobs.edit')->with('job', $job)->with($this->getOptionItems());
    }

    /**
     * Update the specified Job in storage.
     *
     * @param  int              $id
     * @param UpdateJobRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobRequest $request)
    {
        $job = $this->getRepositoryObj()->find($id);

        if (empty($job)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobs.singular')]));

            return redirect(route('utility.jobs.index'));
        }

        $job = $this->getRepositoryObj()->update($request->all(), $id);
        if($job instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $job->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/jobs.singular')]));

        return redirect(route('utility.jobs.index'));
    }

    /**
     * Remove the specified Job from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $job = $this->getRepositoryObj()->find($id);

        if (empty($job)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobs.singular')]));

            return redirect(route('utility.jobs.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/jobs.singular')]));

        return redirect(route('utility.jobs.index'));
    }

    /**
     * Provide options item based on relationship model Job from storage.         
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
