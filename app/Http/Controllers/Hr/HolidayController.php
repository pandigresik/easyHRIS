<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\HolidayDataTable;

use App\Http\Requests\Hr\CreateHolidayRequest;
use App\Http\Requests\Hr\UpdateHolidayRequest;
use App\Repositories\Hr\HolidayRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class HolidayController extends AppBaseController
{
    /** @var  HolidayRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = HolidayRepository::class;
    }

    /**
     * Display a listing of the Holiday.
     *
     * @param HolidayDataTable $holidayDataTable
     * @return Response
     */
    public function index(HolidayDataTable $holidayDataTable)
    {
        return $holidayDataTable->render('hr.holidays.index');
    }

    /**
     * Show the form for creating a new Holiday.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.holidays.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Holiday in storage.
     *
     * @param CreateHolidayRequest $request
     *
     * @return Response
     */
    public function store(CreateHolidayRequest $request)
    {
        $input = $request->all();

        $holiday = $this->getRepositoryObj()->create($input);
        if ($holiday instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $holiday->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/holidays.singular')]));

        return redirect(route('hr.holidays.index'));
    }

    /**
     * Display the specified Holiday.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $holiday = $this->getRepositoryObj()->find($id);

        if (empty($holiday)) {
            Flash::error(__('models/holidays.singular').' '.__('messages.not_found'));

            return redirect(route('hr.holidays.index'));
        }

        return view('hr.holidays.show')->with('holiday', $holiday);
    }

    /**
     * Show the form for editing the specified Holiday.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $holiday = $this->getRepositoryObj()->find($id);

        if (empty($holiday)) {
            Flash::error(__('messages.not_found', ['model' => __('models/holidays.singular')]));

            return redirect(route('hr.holidays.index'));
        }

        return view('hr.holidays.edit')->with('holiday', $holiday)->with($this->getOptionItems());
    }

    /**
     * Update the specified Holiday in storage.
     *
     * @param  int              $id
     * @param UpdateHolidayRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHolidayRequest $request)
    {
        $holiday = $this->getRepositoryObj()->find($id);

        if (empty($holiday)) {
            Flash::error(__('messages.not_found', ['model' => __('models/holidays.singular')]));

            return redirect(route('hr.holidays.index'));
        }

        $holiday = $this->getRepositoryObj()->update($request->all(), $id);
        if ($holiday instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $holiday->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/holidays.singular')]));

        return redirect(route('hr.holidays.index'));
    }

    /**
     * Remove the specified Holiday from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $holiday = $this->getRepositoryObj()->find($id);

        if (empty($holiday)) {
            Flash::error(__('messages.not_found', ['model' => __('models/holidays.singular')]));

            return redirect(route('hr.holidays.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/holidays.singular')]));

        return redirect(route('hr.holidays.index'));
    }

    /**
     * Provide options item based on relationship model Holiday from storage.
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
