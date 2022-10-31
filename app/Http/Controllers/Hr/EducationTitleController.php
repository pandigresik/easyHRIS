<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\EducationTitleDataTable;

use App\Http\Requests\Hr\CreateEducationTitleRequest;
use App\Http\Requests\Hr\UpdateEducationTitleRequest;
use App\Repositories\Hr\EducationTitleRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class EducationTitleController extends AppBaseController
{
    /** @var  EducationTitleRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = EducationTitleRepository::class;
    }

    /**
     * Display a listing of the EducationTitle.
     *
     * @param EducationTitleDataTable $educationTitleDataTable
     * @return Response
     */
    public function index(EducationTitleDataTable $educationTitleDataTable)
    {
        return $educationTitleDataTable->render('hr.education_titles.index');
    }

    /**
     * Show the form for creating a new EducationTitle.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.education_titles.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created EducationTitle in storage.
     *
     * @param CreateEducationTitleRequest $request
     *
     * @return Response
     */
    public function store(CreateEducationTitleRequest $request)
    {
        $input = $request->all();

        $educationTitle = $this->getRepositoryObj()->create($input);
        if ($educationTitle instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $educationTitle->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/educationTitles.singular')]));

        return redirect(route('hr.educationTitles.index'));
    }

    /**
     * Display the specified EducationTitle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $educationTitle = $this->getRepositoryObj()->find($id);

        if (empty($educationTitle)) {
            Flash::error(__('models/educationTitles.singular').' '.__('messages.not_found'));

            return redirect(route('hr.educationTitles.index'));
        }

        return view('hr.education_titles.show')->with('educationTitle', $educationTitle);
    }

    /**
     * Show the form for editing the specified EducationTitle.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $educationTitle = $this->getRepositoryObj()->find($id);

        if (empty($educationTitle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/educationTitles.singular')]));

            return redirect(route('hr.educationTitles.index'));
        }

        return view('hr.education_titles.edit')->with('educationTitle', $educationTitle)->with($this->getOptionItems());
    }

    /**
     * Update the specified EducationTitle in storage.
     *
     * @param  int              $id
     * @param UpdateEducationTitleRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEducationTitleRequest $request)
    {
        $educationTitle = $this->getRepositoryObj()->find($id);

        if (empty($educationTitle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/educationTitles.singular')]));

            return redirect(route('hr.educationTitles.index'));
        }

        $educationTitle = $this->getRepositoryObj()->update($request->all(), $id);
        if ($educationTitle instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $educationTitle->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/educationTitles.singular')]));

        return redirect(route('hr.educationTitles.index'));
    }

    /**
     * Remove the specified EducationTitle from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $educationTitle = $this->getRepositoryObj()->find($id);

        if (empty($educationTitle)) {
            Flash::error(__('messages.not_found', ['model' => __('models/educationTitles.singular')]));

            return redirect(route('hr.educationTitles.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/educationTitles.singular')]));

        return redirect(route('hr.educationTitles.index'));
    }

    /**
     * Provide options item based on relationship model EducationTitle from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        return [

        ];
    }
}
