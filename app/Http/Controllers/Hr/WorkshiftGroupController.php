<?php

namespace App\Http\Controllers\Hr;

use Acaronlex\LaravelCalendar\Calendar;
use App\DataTables\Hr\WorkshiftGroupDataTable;
use App\Http\Requests\Hr\CreateWorkshiftGroupRequest;
use App\Http\Requests\Hr\UpdateWorkshiftGroupRequest;
use App\Repositories\Hr\WorkshiftGroupRepository;
use App\Repositories\Hr\ShiftmentGroupRepository;
use App\Repositories\Hr\ShiftmentRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;
use Illuminate\Http\Request;

class WorkshiftGroupController extends AppBaseController
{
    /** @var  WorkshiftGroupRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = WorkshiftGroupRepository::class;
    }

    /**
     * Display a listing of the WorkshiftGroup.
     *
     * @param WorkshiftGroupDataTable $workshiftGroupDataTable
     * @return Response
     */
    public function index(WorkshiftGroupDataTable $workshiftGroupDataTable)
    {
        return $workshiftGroupDataTable->render('hr.workshift_groups.index');
    }

    /**
     * Show the form for creating a new WorkshiftGroup.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.workshift_groups.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created WorkshiftGroup in storage.
     *
     * @param CreateWorkshiftGroupRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkshiftGroupRequest $request)
    {
        $input = $request->all();

        $workshiftGroup = $this->getRepositoryObj()->create($input);
        if($workshiftGroup instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $workshiftGroup->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/workshiftGroups.singular')]));

        return redirect(route('hr.workshiftGroups.index'));
    }

    /**
     * Display the specified WorkshiftGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workshiftGroup = $this->getRepositoryObj()->find($id);

        if (empty($workshiftGroup)) {
            Flash::error(__('models/workshiftGroups.singular').' '.__('messages.not_found'));

            return redirect(route('hr.workshiftGroups.index'));
        }

        return view('hr.workshift_groups.show')->with('workshiftGroup', $workshiftGroup);
    }

    /**
     * Show the form for editing the specified WorkshiftGroup.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workshiftGroup = $this->getRepositoryObj()->find($id);

        if (empty($workshiftGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workshiftGroups.singular')]));

            return redirect(route('hr.workshiftGroups.index'));
        }
        
        return view('hr.workshift_groups.edit')->with('workshiftGroup', $workshiftGroup)->with($this->getOptionItems());
    }

    /**
     * Update the specified WorkshiftGroup in storage.
     *
     * @param  int              $id
     * @param UpdateWorkshiftGroupRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkshiftGroupRequest $request)
    {
        $workshiftGroup = $this->getRepositoryObj()->find($id);

        if (empty($workshiftGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workshiftGroups.singular')]));

            return redirect(route('hr.workshiftGroups.index'));
        }

        $workshiftGroup = $this->getRepositoryObj()->update($request->all(), $id);
        if($workshiftGroup instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $workshiftGroup->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/workshiftGroups.singular')]));

        return redirect(route('hr.workshiftGroups.index'));
    }

    /**
     * Remove the specified WorkshiftGroup from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $workshiftGroup = $this->getRepositoryObj()->find($id);

        if (empty($workshiftGroup)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workshiftGroups.singular')]));

            return redirect(route('hr.workshiftGroups.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/workshiftGroups.singular')]));

        return redirect(route('hr.workshiftGroups.index'));
    }

    /**
     * Provide options item based on relationship model WorkshiftGroup from storage.         
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems(){        
        $shiftmentGroup = new ShiftmentGroupRepository();
        $shiftment = new ShiftmentRepository();
        return [
            'shiftmentGroupItems' => ['' => __('crud.option.shiftmentGroup_placeholder')] + $shiftmentGroup->pluck(),
            'shiftmentItems' => ['' => __('crud.option.shiftment_placeholder')] + $shiftment->pluck()            
        ];
    }

    /**
     * Generate schedule workshift
     *
     * @return Response
     */
    public function generate(Request $request)
    {
        $period = generatePeriodFromString($request->get('work_date'));
        $shiftmentGroup = $request->get('shiftment_group_id');
        $data = [
            'startDate' => $period['startDate'],
            'endDate' => $period['endDate'],
            'shiftmentGroup' => $shiftmentGroup
        ];
        $initialDate = $period['startDate'];
        $workshift = $this->getRepositoryObj()->generateWorkshift($data);
        $events = [];
        foreach($workshift['schedule'] as $date => $event){
            $events[] = [
                'title' => $this->generateTitleSchedule($event),
                'start' => $date,
                'end' => $date,
            ];
        }
        return view('hr.workshift_groups.calendar', compact('events', 'initialDate'));
    }

    private function generateTitleSchedule($shiftment){
        return $shiftment->code.'_('.$shiftment->start_hour.'_'.$shiftment->end_hour.')';
    }
}
