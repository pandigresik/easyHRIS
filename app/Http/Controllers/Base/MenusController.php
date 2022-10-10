<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\MenusDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Base\CreateMenusRequest;
use App\Http\Requests\Base\UpdateMenusRequest;
use App\Repositories\Base\MenusRepository;
use App\Repositories\Base\PermissionRepository;
use Flash;
use Illuminate\Support\Str;
use Response;

class MenusController extends AppBaseController
{
    /** @var MenusRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = MenusRepository::class;
    }

    /**
     * Display a listing of the Menus.
     *
     * @return Response
     */
    public function index(MenusDataTable $menusDataTable)
    {
        return $menusDataTable->render('base.menus.index');
    }

    /**
     * Show the form for creating a new Menus.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.menus.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Menus in storage.
     *
     * @return Response
     */
    public function store(CreateMenusRequest $request)
    {
        $input = $request->all();

        $menus = $this->getRepositoryObj()->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/menus.singular')]));

        return redirect(route('base.menus.index'));
    }

    /**
     * Display the specified Menus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $menus = $this->getRepositoryObj()->find($id);

        if (empty($menus)) {
            Flash::error(__('models/menus.singular').' '.__('messages.not_found'));

            return redirect(route('base.menus.index'));
        }

        return view('base.menus.show')->with('menus', $menus);
    }

    /**
     * Show the form for editing the specified Menus.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $menus = $this->getRepositoryObj()->find($id);

        if (empty($menus)) {
            Flash::error(__('messages.not_found', ['model' => __('models/menus.singular')]));

            return redirect(route('base.menus.index'));
        }

        return view('base.menus.edit')->with('menus', $menus)->with($this->getOptionItems())->with(['selectedPermission' => $menus->permissions->pluck('id')->toArray()]);
    }

    /**
     * Update the specified Menus in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, UpdateMenusRequest $request)
    {
        $menus = $this->getRepositoryObj()->find($id);

        if (empty($menus)) {
            Flash::error(__('messages.not_found', ['model' => __('models/menus.singular')]));

            return redirect(route('base.menus.index'));
        }

        $menus = $this->getRepositoryObj()->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/menus.singular')]));

        return redirect(route('base.menus.index'));
    }

    /**
     * Remove the specified Menus from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $menus = $this->getRepositoryObj()->find($id);

        if (empty($menus)) {
            Flash::error(__('messages.not_found', ['model' => __('models/menus.singular')]));

            return redirect(route('base.menus.index'));
        }

        $this->getRepositoryObj()->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/menus.singular')]));

        return redirect(route('base.menus.index'));
    }

    /**
     * Provide options item based on relationship model Menus from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $menuParent = new MenusRepository();
        $permission = new PermissionRepository();

        return [
            'statusItems' => ['1' => __('crud.state_active'), '0' => __('crud.state_nonactive')],
            'parentItems' => $menuParent->pluck(),
            'permissionItems' => $permission->pluck(),
            'routeItems' => $this->listRoute(),
            'iconItems' => array_combine(config('icon.coreui'), config('icon.coreui')),
        ];
    }

    private function listRoute()
    {
        $routeCollection = \Route::getRoutes();
        $listRoute = [];
        foreach ($routeCollection as $route) {
            if (Str::startsWith($route->uri, 'api')) {
                continue;
            }
            if (Str::startsWith($route->uri, '_')) {
                continue;
            }
            if (Str::startsWith($route->uri, 'generator')) {
                continue;
            }
            if (Str::contains($route->uri, '{')) {
                continue;
            }

            $listRoute[$route->uri] = $route->uri;
        }

        return $listRoute;
    }
}
