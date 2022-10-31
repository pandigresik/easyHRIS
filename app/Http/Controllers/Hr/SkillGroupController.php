<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SkillGroupDataTable;

use App\Http\Requests\Hr\CreateSkillGroupRequest;
use App\Http\Requests\Hr\UpdateSkillGroupRequest;
use App\Repositories\Hr\SkillGroupRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SkillGroupController extends AppBaseController
{
    /** @var  SkillGroupRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SkillGroupRepository::class;
    }

    /**
     * Display a listing of the SkillGroup.
     *
     * @param SkillGroupDataTable $skillGroupDataTable
     * @return Response
     */
    public function index(SkillGroupDataTable $skillGroupDataTable)
    {
        return $skillGroupDataTable->render('hr.skill_groups.index');
    }

    /**
     * Show the form for creating a new SkillGroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.skill_groups.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created SkillGroup in storage.
     *
     * @param CreateSkillGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateSkillGroupRequest $request)
    {
        $input = $request->all();

        $skillGroup = $this->getRepositoryObj()->create($input);
        if ($skillGroup instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $skillGroup->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/skillGroups.singular')]));

        return redirect(route('hr.skillGroups.index'));
    }

    /**
     * Display the specified SkillGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $skillGroup = $this->getRepositoryObj()->find($id);

        if (empty($skillGroup)) {
            Flash::error(__('models/skillGroups.singular').' '.__('messages.not_found'));

            return redirect(route('hr.skillGroups.index'));
        }

        return view('hr.skill_groups.show')->with('skillGroup', $skillGroup);
    }

    /**
     * Show the form for editing the specified SkillGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $skillGroup = $this->getRepositoryObj()->find($id);

        if (empty($skillGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillGroups.singular')]));

            return redirect(route('hr.skillGroups.index'));
        }

        return view('hr.skill_groups.edit')->with('skillGroup', $skillGroup)->with($this->getOptionItems());
    }

    /**
     * Update the specified SkillGroup in storage.
     *
     * @param  int              $id
     * @param UpdateSkillGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSkillGroupRequest $request)
    {
        $skillGroup = $this->getRepositoryObj()->find($id);

        if (empty($skillGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillGroups.singular')]));

            return redirect(route('hr.skillGroups.index'));
        }

        $skillGroup = $this->getRepositoryObj()->update($request->all(), $id);
        if ($skillGroup instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $skillGroup->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/skillGroups.singular')]));

        return redirect(route('hr.skillGroups.index'));
    }

    /**
     * Remove the specified SkillGroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $skillGroup = $this->getRepositoryObj()->find($id);

        if (empty($skillGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skillGroups.singular')]));

            return redirect(route('hr.skillGroups.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/skillGroups.singular')]));

        return redirect(route('hr.skillGroups.index'));
    }

    /**
     * Provide options item based on relationship model SkillGroup from storage.
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
