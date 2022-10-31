<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\SkillDataTable;

use App\Http\Requests\Hr\CreateSkillRequest;
use App\Http\Requests\Hr\UpdateSkillRequest;
use App\Repositories\Hr\SkillRepository;
use App\Repositories\Hr\SkillGroupRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class SkillController extends AppBaseController
{
    /** @var  SkillRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = SkillRepository::class;
    }

    /**
     * Display a listing of the Skill.
     *
     * @param SkillDataTable $skillDataTable
     * @return Response
     */
    public function index(SkillDataTable $skillDataTable)
    {
        return $skillDataTable->render('hr.skills.index');
    }

    /**
     * Show the form for creating a new Skill.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.skills.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Skill in storage.
     *
     * @param CreateSkillRequest $request
     *
     * @return Response
     */
    public function store(CreateSkillRequest $request)
    {
        $input = $request->all();

        $skill = $this->getRepositoryObj()->create($input);
        if ($skill instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $skill->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/skills.singular')]));

        return redirect(route('hr.skills.index'));
    }

    /**
     * Display the specified Skill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $skill = $this->getRepositoryObj()->find($id);

        if (empty($skill)) {
            Flash::error(__('models/skills.singular').' '.__('messages.not_found'));

            return redirect(route('hr.skills.index'));
        }

        return view('hr.skills.show')->with('skill', $skill);
    }

    /**
     * Show the form for editing the specified Skill.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $skill = $this->getRepositoryObj()->find($id);

        if (empty($skill)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skills.singular')]));

            return redirect(route('hr.skills.index'));
        }

        return view('hr.skills.edit')->with('skill', $skill)->with($this->getOptionItems());
    }

    /**
     * Update the specified Skill in storage.
     *
     * @param  int              $id
     * @param UpdateSkillRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateSkillRequest $request)
    {
        $skill = $this->getRepositoryObj()->find($id);

        if (empty($skill)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skills.singular')]));

            return redirect(route('hr.skills.index'));
        }

        $skill = $this->getRepositoryObj()->update($request->all(), $id);
        if ($skill instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $skill->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/skills.singular')]));

        return redirect(route('hr.skills.index'));
    }

    /**
     * Remove the specified Skill from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $skill = $this->getRepositoryObj()->find($id);

        if (empty($skill)) {
            Flash::error(__('messages.not_found', ['model' => __('models/skills.singular')]));

            return redirect(route('hr.skills.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/skills.singular')]));

        return redirect(route('hr.skills.index'));
    }

    /**
     * Provide options item based on relationship model Skill from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $skillGroup = new SkillGroupRepository();
        return [
            'skillGroupItems' => ['' => __('crud.option.skillGroup_placeholder')] + $skillGroup->pluck()
        ];
    }
}
