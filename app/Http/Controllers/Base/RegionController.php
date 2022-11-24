<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\RegionDataTable;

use App\Http\Requests\Base\CreateRegionRequest;
use App\Http\Requests\Base\UpdateRegionRequest;
use App\Repositories\Base\RegionRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class RegionController extends AppBaseController
{
    /** @var  RegionRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = RegionRepository::class;
    }

    /**
     * Display a listing of the Region.
     *
     * @param RegionDataTable $regionDataTable
     * @return Response
     */
    public function index(RegionDataTable $regionDataTable)
    {
        return $regionDataTable->render('base.regions.index');
    }

    /**
     * Show the form for creating a new Region.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.regions.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Region in storage.
     *
     * @param CreateRegionRequest $request
     *
     * @return Response
     */
    public function store(CreateRegionRequest $request)
    {
        $input = $request->all();

        $region = $this->getRepositoryObj()->create($input);
        if ($region instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $region->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/regions.singular')]));

        return redirect(route('base.regions.index'));
    }

    /**
     * Display the specified Region.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $region = $this->getRepositoryObj()->find($id);

        if (empty($region)) {
            Flash::error(__('models/regions.singular').' '.__('messages.not_found'));

            return redirect(route('base.regions.index'));
        }

        return view('base.regions.show')->with('region', $region);
    }

    /**
     * Show the form for editing the specified Region.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $region = $this->getRepositoryObj()->find($id);

        if (empty($region)) {
            Flash::error(__('messages.not_found', ['model' => __('models/regions.singular')]));

            return redirect(route('base.regions.index'));
        }

        return view('base.regions.edit')->with('region', $region)->with($this->getOptionItems());
    }

    /**
     * Update the specified Region in storage.
     *
     * @param  int              $id
     * @param UpdateRegionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRegionRequest $request)
    {
        $region = $this->getRepositoryObj()->find($id);

        if (empty($region)) {
            Flash::error(__('messages.not_found', ['model' => __('models/regions.singular')]));

            return redirect(route('base.regions.index'));
        }

        $region = $this->getRepositoryObj()->update($request->all(), $id);
        if ($region instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $region->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/regions.singular')]));

        return redirect(route('base.regions.index'));
    }

    /**
     * Remove the specified Region from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $region = $this->getRepositoryObj()->find($id);

        if (empty($region)) {
            Flash::error(__('messages.not_found', ['model' => __('models/regions.singular')]));

            return redirect(route('base.regions.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/regions.singular')]));

        return redirect(route('base.regions.index'));
    }

    /**
     * Provide options item based on relationship model Region from storage.
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
