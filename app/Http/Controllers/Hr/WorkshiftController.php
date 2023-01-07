<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\WorkshiftDataTable;
use App\Http\Requests\Hr\CreateWorkshiftRequest;
use App\Http\Requests\Hr\UpdateWorkshiftRequest;
use App\Repositories\Hr\WorkshiftRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use App\Repositories\Hr\ShiftmentGroupRepository;
use Response;
use Exception;
use Illuminate\Http\Request;

class WorkshiftController extends AppBaseController
{
    /** @var  WorkshiftRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = WorkshiftRepository::class;
    }

    /**
     * Display a listing of the Workshift.
     *
     * @param WorkshiftDataTable $workshiftDataTable
     * @return Response
     */
    public function index(WorkshiftDataTable $workshiftDataTable)
    {
        return $workshiftDataTable->render('hr.workshifts.index');
    }

    /**
     * Show the form for creating a new Workshift.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.workshifts.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Workshift in storage.
     *
     * @param CreateWorkshiftRequest $request
     *
     * @return Response
     */
    public function store(CreateWorkshiftRequest $request)
    {
        $input = $request->all();

        $workshift = $this->getRepositoryObj()->generateSchedule($input);
        if ($workshift instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $workshift->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/workshifts.singular')]));

        return redirect(route('hr.workshifts.index'));
    }

    /**
     * Display the specified Workshift.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workshift = $this->getRepositoryObj()->find($id);

        if (empty($workshift)) {
            Flash::error(__('models/workshifts.singular').' '.__('messages.not_found'));

            return redirect(route('hr.workshifts.index'));
        }

        return view('hr.workshifts.show')->with('workshift', $workshift);
    }

    /**
     * Show the form for editing the specified Workshift.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workshift = $this->getRepositoryObj()->find($id);

        if (empty($workshift)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workshifts.singular')]));

            return redirect(route('hr.workshifts.index'));
        }

        return view('hr.workshifts.edit')->with('workshift', $workshift)->with($this->getOptionItems());
    }

    /**
     * Update the specified Workshift in storage.
     *
     * @param  int              $id
     * @param UpdateWorkshiftRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateWorkshiftRequest $request)
    {
        $workshift = $this->getRepositoryObj()->find($id);

        if (empty($workshift)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workshifts.singular')]));

            return redirect(route('hr.workshifts.index'));
        }

        $workshift = $this->getRepositoryObj()->update($request->all(), $id);
        if ($workshift instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $workshift->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/workshifts.singular')]));

        return redirect(route('hr.workshifts.index'));
    }

    /**
     * Remove the specified Workshift from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $workshift = $this->getRepositoryObj()->find($id);

        if (empty($workshift)) {
            Flash::error(__('messages.not_found', ['model' => __('models/workshifts.singular')]));

            return redirect(route('hr.workshifts.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/workshifts.singular')]));

        return redirect(route('hr.workshifts.index'));
    }

    /**
     * Provide options item based on relationship model Workshift from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $shiftmentGroup = new ShiftmentGroupRepository();
        return [
            'shiftmentGroupItems' => $shiftmentGroup->pluck(),
        ];
    }

    /**
     * Generate schedule workshift
     *
     * @return Response
     */
    public function generate(Request $request)
    {        
        $period = generatePeriodFromString($request->get('work_date_period'));
        $shiftmentGroup = $request->get('shiftment_group_id');
        $data = [
            'startDate' => $period['startDate'],
            'endDate' => $period['endDate'],
            'shiftmentGroup' => $shiftmentGroup
        ];
        $initialDate = $period['startDate'];
        $workshift = $this->getRepositoryObj()->generateWorkshift($data);
        $events = [];
        $dataInsert = [];
        $eventTimeFormat = [ // like '14:30:00'
            'hour' => '2-digit',
            'minute' =>'2-digit',
            'second' => '2-digit',
            'hour12' => false
        ];
        if(!empty($workshift['schedule'])){
            foreach($workshift['schedule'] as $date => $event){                
                $events[] = [
                    'title' => $event['code'].' ('.$event['start_hour'].'-'.$event['end_hour'].')',
                    'allDay' => true,
                    'start' => $date,
                    'color' => $event['start_hour'] == $event['end_hour'] ? 'red' : 'green'
                ];            
            }
            return view('hr.workshifts.calendar', compact('events', 'eventTimeFormat', 'initialDate', 'dataInsert'));
        }else{
            return '<div class="row col-12"><div class="text-center text-danger">Jadwal shift grup belum digenerate</div></div>';
        }
        
    }
}
