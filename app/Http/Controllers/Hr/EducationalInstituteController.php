<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\EducationalInstituteDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateEducationalInstituteRequest;
use App\Http\Requests\Hr\UpdateEducationalInstituteRequest;
use App\Repositories\Hr\EducationalInstituteRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class EducationalInstituteController extends AppBaseController
{
    /** @var  EducationalInstituteRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = EducationalInstituteRepository::class;
    }

    /**
     * Display a listing of the EducationalInstitute.
     *
     * @param EducationalInstituteDataTable $educationalInstituteDataTable
     * @return Response
     */
    public function index(EducationalInstituteDataTable $educationalInstituteDataTable)
    {
        return $educationalInstituteDataTable->render('hr.educational_institutes.index');
    }

    /**
     * Show the form for creating a new EducationalInstitute.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.educational_institutes.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created EducationalInstitute in storage.
     *
     * @param CreateEducationalInstituteRequest $request
     *
     * @return Response
     */
    public function store(CreateEducationalInstituteRequest $request)
    {
        $input = $request->all();

        $educationalInstitute = $this->getRepositoryObj()->create($input);
        if ($educationalInstitute instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $educationalInstitute->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/educationalInstitutes.singular')]));

        return redirect(route('hr.educationalInstitutes.index'));
    }

    /**
     * Display the specified EducationalInstitute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $educationalInstitute = $this->getRepositoryObj()->find($id);

        if (empty($educationalInstitute)) {
            Flash::error(__('models/educationalInstitutes.singular').' '.__('messages.not_found'));

            return redirect(route('hr.educationalInstitutes.index'));
        }

        return view('hr.educational_institutes.show')->with('educationalInstitute', $educationalInstitute);
    }

    /**
     * Show the form for editing the specified EducationalInstitute.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $educationalInstitute = $this->getRepositoryObj()->find($id);

        if (empty($educationalInstitute)) {
            Flash::error(__('messages.not_found', ['model' => __('models/educationalInstitutes.singular')]));

            return redirect(route('hr.educationalInstitutes.index'));
        }

        return view('hr.educational_institutes.edit')->with('educationalInstitute', $educationalInstitute)->with($this->getOptionItems());
    }

    /**
     * Update the specified EducationalInstitute in storage.
     *
     * @param  int              $id
     * @param UpdateEducationalInstituteRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEducationalInstituteRequest $request)
    {
        $educationalInstitute = $this->getRepositoryObj()->find($id);

        if (empty($educationalInstitute)) {
            Flash::error(__('messages.not_found', ['model' => __('models/educationalInstitutes.singular')]));

            return redirect(route('hr.educationalInstitutes.index'));
        }

        $educationalInstitute = $this->getRepositoryObj()->update($request->all(), $id);
        if ($educationalInstitute instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $educationalInstitute->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/educationalInstitutes.singular')]));

        return redirect(route('hr.educationalInstitutes.index'));
    }

    /**
     * Remove the specified EducationalInstitute from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $educationalInstitute = $this->getRepositoryObj()->find($id);

        if (empty($educationalInstitute)) {
            Flash::error(__('messages.not_found', ['model' => __('models/educationalInstitutes.singular')]));

            return redirect(route('hr.educationalInstitutes.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/educationalInstitutes.singular')]));

        return redirect(route('hr.educationalInstitutes.index'));
    }

    /**
     * Provide options item based on relationship model EducationalInstitute from storage.
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
