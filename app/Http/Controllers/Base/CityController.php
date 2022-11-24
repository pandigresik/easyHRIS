<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\CityDataTable;

use App\Http\Requests\Base\CreateCityRequest;
use App\Http\Requests\Base\UpdateCityRequest;
use App\Repositories\Base\CityRepository;
use App\Repositories\Base\RegionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class CityController extends AppBaseController
{
    /** @var  CityRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = CityRepository::class;
    }

    /**
     * Display a listing of the City.
     *
     * @param CityDataTable $cityDataTable
     * @return Response
     */
    public function index(CityDataTable $cityDataTable)
    {
        return $cityDataTable->render('base.cities.index');
    }

    /**
     * Show the form for creating a new City.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.cities.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created City in storage.
     *
     * @param CreateCityRequest $request
     *
     * @return Response
     */
    public function store(CreateCityRequest $request)
    {
        $input = $request->all();

        $city = $this->getRepositoryObj()->create($input);
        if ($city instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $city->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/cities.singular')]));

        return redirect(route('base.cities.index'));
    }

    /**
     * Display the specified City.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $city = $this->getRepositoryObj()->find($id);

        if (empty($city)) {
            Flash::error(__('models/cities.singular').' '.__('messages.not_found'));

            return redirect(route('base.cities.index'));
        }

        return view('base.cities.show')->with('city', $city);
    }

    /**
     * Show the form for editing the specified City.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $city = $this->getRepositoryObj()->find($id);

        if (empty($city)) {
            Flash::error(__('messages.not_found', ['model' => __('models/cities.singular')]));

            return redirect(route('base.cities.index'));
        }

        return view('base.cities.edit')->with('city', $city)->with($this->getOptionItems());
    }

    /**
     * Update the specified City in storage.
     *
     * @param  int              $id
     * @param UpdateCityRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCityRequest $request)
    {
        $city = $this->getRepositoryObj()->find($id);

        if (empty($city)) {
            Flash::error(__('messages.not_found', ['model' => __('models/cities.singular')]));

            return redirect(route('base.cities.index'));
        }

        $city = $this->getRepositoryObj()->update($request->all(), $id);
        if ($city instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $city->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/cities.singular')]));

        return redirect(route('base.cities.index'));
    }

    /**
     * Remove the specified City from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $city = $this->getRepositoryObj()->find($id);

        if (empty($city)) {
            Flash::error(__('messages.not_found', ['model' => __('models/cities.singular')]));

            return redirect(route('base.cities.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/cities.singular')]));

        return redirect(route('base.cities.index'));
    }

    /**
     * Provide options item based on relationship model City from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $region = new RegionRepository();
        return [
            'regionItems' => ['' => __('crud.option.region_placeholder')] + $region->pluck()
        ];
    }
}
