<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\JobTitleDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateJobTitleRequest;
use App\Http\Requests\Hr\UpdateJobTitleRequest;
use App\Repositories\Hr\JobTitleRepository;
use App\Repositories\Hr\JobLevelRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class JobTitleController extends AppBaseController
{
    /** @var  JobTitleRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = JobTitleRepository::class;
    }

    /**
     * Display a listing of the JobTitle.
     *
     * @param JobTitleDataTable $jobTitleDataTable
     * @return Response
     */
    public function index(JobTitleDataTable $jobTitleDataTable)
    {
        return $jobTitleDataTable->render('hr.job_titles.index');
    }

    /**
     * Show the form for creating a new JobTitle.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.job_titles.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created JobTitle in storage.
     *
     * @param CreateJobTitleRequest $request
     *
     * @return Response
     */
    public function store(CreateJobTitleRequest $request)
    {
        $input = $request->all();

        $jobTitle = $this->getRepositoryObj()->create($input);
        if($jobTitle instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $jobTitle->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/jobTitles.singular')]));

        return redirect(route('hr.jobTitles.index'));
    }

    /**
     * Display the specified JobTitle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobTitle = $this->getRepositoryObj()->find($id);

        if (empty($jobTitle)) {
            Flash::error(__('models/jobTitles.singular').' '.__('messages.not_found'));

            return redirect(route('hr.jobTitles.index'));
        }

        return view('hr.job_titles.show')->with('jobTitle', $jobTitle);
    }

    /**
     * Show the form for editing the specified JobTitle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobTitle = $this->getRepositoryObj()->find($id);

        if (empty($jobTitle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobTitles.singular')]));

            return redirect(route('hr.jobTitles.index'));
        }
        
        return view('hr.job_titles.edit')->with('jobTitle', $jobTitle)->with($this->getOptionItems());
    }

    /**
     * Update the specified JobTitle in storage.
     *
     * @param  int              $id
     * @param UpdateJobTitleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobTitleRequest $request)
    {
        $jobTitle = $this->getRepositoryObj()->find($id);

        if (empty($jobTitle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobTitles.singular')]));

            return redirect(route('hr.jobTitles.index'));
        }

        $jobTitle = $this->getRepositoryObj()->update($request->all(), $id);
        if($jobTitle instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $jobTitle->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/jobTitles.singular')]));

        return redirect(route('hr.jobTitles.index'));
    }

    /**
     * Remove the specified JobTitle from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobTitle = $this->getRepositoryObj()->find($id);

        if (empty($jobTitle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobTitles.singular')]));

            return redirect(route('hr.jobTitles.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/jobTitles.singular')]));

        return redirect(route('hr.jobTitles.index'));
    }

    /**
     * Provide options item based on relationship model JobTitle from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $jobLevel = new JobLevelRepository();
        return [
            'jobLevelItems' => ['' => __('crud.option.jobLevel_placeholder')] + $jobLevel->pluck()            
        ];
    }
}
