<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\RoleDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Base\CreateRoleRequest;
use App\Http\Requests\Base\UpdateRoleRequest;
use App\Repositories\Base\PermissionRepository;
use App\Repositories\Base\RoleRepository;
use Flash;
use Response;

class RoleController extends AppBaseController
{
    /** @var RoleRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = RoleRepository::class;
    }

    /**
     * Display a listing of the Role.
     *
     * @return Response
     */
    public function index(RoleDataTable $roleDataTable)
    {
        return $roleDataTable->render('base.roles.index');
    }

    /**
     * Show the form for creating a new Role.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.roles.create')->with(['permissions' => $this->listPermission()]);
    }

    /**
     * Store a newly created Role in storage.
     *
     * @return Response
     */
    public function store(CreateRoleRequest $request)
    {
        $input = $request->all();

        $role = $this->getRepositoryObj()->create($input);
        Flash::success('Role saved successfully.');

        return redirect(route('base.roles.index'));
    }

    /**
     * Display the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $role = $this->getRepositoryObj()->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('base.roles.index'));
        }

        return view('base.roles.show')->with(['role' => $role, 'permissions' => $this->listPermission()]);
    }

    /**
     * Show the form for editing the specified Role.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $role = $this->getRepositoryObj()->find($id);
        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('base.roles.index'));
        }

        return view('base.roles.edit')->with(['role' => $role, 'permissions' => $this->listPermission()]);
    }

    /**
     * Update the specified Role in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, UpdateRoleRequest $request)
    {
        $role = $this->getRepositoryObj()->find($id);
        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('base.roles.index'));
        }

        $role = $this->getRepositoryObj()->update($request->all(), $id);
        Flash::success('Role updated successfully.');

        return redirect(route('base.roles.index'));
    }

    /**
     * Remove the specified Role from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $role = $this->getRepositoryObj()->find($id);

        if (empty($role)) {
            Flash::error('Role not found');

            return redirect(route('base.roles.index'));
        }

        $this->getRepositoryObj()->delete($id);

        Flash::success('Role deleted successfully.');

        return redirect(route('base.roles.index'));
    }

    private function listPermission()
    {
        $app = app();
        $permissions = new PermissionRepository($app);

        return $permissions->all()->mapToGroups(function ($message) {
            list($index, $action) = explode('-', $message->name);

            return [$index => $message];
        });
    }
}
