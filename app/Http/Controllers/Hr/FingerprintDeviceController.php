<?php

namespace App\Http\Controllers\Hr;

use App\DataTables\Hr\FingerprintDeviceDataTable;
use App\Http\Requests\Hr;
use App\Http\Requests\Hr\CreateFingerprintDeviceRequest;
use App\Http\Requests\Hr\UpdateFingerprintDeviceRequest;
use App\Repositories\Hr\FingerprintDeviceRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class FingerprintDeviceController extends AppBaseController
{
    /** @var  FingerprintDeviceRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = FingerprintDeviceRepository::class;
    }

    /**
     * Display a listing of the FingerprintDevice.
     *
     * @param FingerprintDeviceDataTable $fingerprintDeviceDataTable
     * @return Response
     */
    public function index(FingerprintDeviceDataTable $fingerprintDeviceDataTable)
    {
        return $fingerprintDeviceDataTable->render('hr.fingerprint_devices.index');
    }

    /**
     * Show the form for creating a new FingerprintDevice.
     *
     * @return Response
     */
    public function create()
    {
        return view('hr.fingerprint_devices.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created FingerprintDevice in storage.
     *
     * @param CreateFingerprintDeviceRequest $request
     *
     * @return Response
     */
    public function store(CreateFingerprintDeviceRequest $request)
    {
        $input = $request->all();

        $fingerprintDevice = $this->getRepositoryObj()->create($input);
        if($fingerprintDevice instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $fingerprintDevice->getMessage()]);
        }
        
        Flash::success(__('messages.saved', ['model' => __('models/fingerprintDevices.singular')]));

        return redirect(route('hr.fingerprintDevices.index'));
    }

    /**
     * Display the specified FingerprintDevice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $fingerprintDevice = $this->getRepositoryObj()->find($id);

        if (empty($fingerprintDevice)) {
            Flash::error(__('models/fingerprintDevices.singular').' '.__('messages.not_found'));

            return redirect(route('hr.fingerprintDevices.index'));
        }

        return view('hr.fingerprint_devices.show')->with('fingerprintDevice', $fingerprintDevice);
    }

    /**
     * Show the form for editing the specified FingerprintDevice.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $fingerprintDevice = $this->getRepositoryObj()->find($id);

        if (empty($fingerprintDevice)) {
            Flash::error(__('messages.not_found', ['model' => __('models/fingerprintDevices.singular')]));

            return redirect(route('hr.fingerprintDevices.index'));
        }
        
        return view('hr.fingerprint_devices.edit')->with('fingerprintDevice', $fingerprintDevice)->with($this->getOptionItems());
    }

    /**
     * Update the specified FingerprintDevice in storage.
     *
     * @param  int              $id
     * @param UpdateFingerprintDeviceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateFingerprintDeviceRequest $request)
    {
        $fingerprintDevice = $this->getRepositoryObj()->find($id);

        if (empty($fingerprintDevice)) {
            Flash::error(__('messages.not_found', ['model' => __('models/fingerprintDevices.singular')]));

            return redirect(route('hr.fingerprintDevices.index'));
        }

        $fingerprintDevice = $this->getRepositoryObj()->update($request->all(), $id);
        if($fingerprintDevice instanceof Exception){
            return redirect()->back()->withInput()->withErrors(['error', $fingerprintDevice->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/fingerprintDevices.singular')]));

        return redirect(route('hr.fingerprintDevices.index'));
    }

    /**
     * Remove the specified FingerprintDevice from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $fingerprintDevice = $this->getRepositoryObj()->find($id);

        if (empty($fingerprintDevice)) {
            Flash::error(__('messages.not_found', ['model' => __('models/fingerprintDevices.singular')]));

            return redirect(route('hr.fingerprintDevices.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);
        
        if($delete instanceof Exception){
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/fingerprintDevices.singular')]));

        return redirect(route('hr.fingerprintDevices.index'));
    }

    /**
     * Provide options item based on relationship model FingerprintDevice from storage.         
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
