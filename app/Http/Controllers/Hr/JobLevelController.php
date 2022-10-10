<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\JobLevelDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateJobLevelRequest;
use App\Http\Requests\Hr\UpdateJobLevelRequest;
use App\Repositories\Hr\JobLevelRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class JobLevelController extends AppBaseController
{
    /** @var  JobLevelRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = JobLevelRepository::class;
    }

    /**
     * Display a listing of the JobLevel.
     *
     * @param JobLevelDataTable $jobLevelDataTable
     * @return Response
     */
    public function index(JobLevelDataTable $jobLevelDataTable)
    {
        return $jobLevelDataTable->render('hr.job_levels.index');
    }

    /**
     * Show the form for creating a new JobLevel.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.job_levels.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created JobLevel in storage.
     *
     * @param CreateJobLevelRequest $request
     *
     * @return Response
     */
    public function store(CreateJobLevelRequest $request)
    {
        $input = $request->all();

        $jobLevel = $this->getRepositoryObj()->create($input);
        if($jobLevel instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $jobLevel->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/jobLevels.singular')]));

        return redirect(route('hr.jobLevels.index'));
    }

    /**
     * Display the specified JobLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $jobLevel = $this->getRepositoryObj()->find($id);

        if (empty($jobLevel)) {
            Flash::error(__('models/jobLevels.singular').' '.__('messages.not_found'));

            return redirect(route('hr.jobLevels.index'));
        }

        return view('hr.job_levels.show')->with('jobLevel', $jobLevel);
    }

    /**
     * Show the form for editing the specified JobLevel.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $jobLevel = $this->getRepositoryObj()->find($id);

        if (empty($jobLevel)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobLevels.singular')]));

            return redirect(route('hr.jobLevels.index'));
        }
        
        return view('hr.job_levels.edit')->with('jobLevel', $jobLevel)->with($this->getOptionItems());
    }

    /**
     * Update the specified JobLevel in storage.
     *
     * @param  int              $id
     * @param UpdateJobLevelRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateJobLevelRequest $request)
    {
        $jobLevel = $this->getRepositoryObj()->find($id);

        if (empty($jobLevel)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobLevels.singular')]));

            return redirect(route('hr.jobLevels.index'));
        }

        $jobLevel = $this->getRepositoryObj()->update($request->all(), $id);
        if($jobLevel instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $jobLevel->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/jobLevels.singular')]));

        return redirect(route('hr.jobLevels.index'));
    }

    /**
     * Remove the specified JobLevel from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $jobLevel = $this->getRepositoryObj()->find($id);

        if (empty($jobLevel)) {
            Flash::error(__('messages.not_found', ['model' => __('models/jobLevels.singular')]));

            return redirect(route('hr.jobLevels.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/jobLevels.singular')]));

        return redirect(route('hr.jobLevels.index'));
    }

    /**
     * Provide options item based on relationship model JobLevel from storage.         
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
