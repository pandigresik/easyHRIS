<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\UserDataTable;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\Base\CreateUserRequest;
use App\Http\Requests\Base\UpdateUserRequest;
use App\Repositories\Base\RoleRepository;
use App\Repositories\Base\UserRepository;
use Flash;
use Response;

class UserController extends AppBaseController
{
    /** @var UserRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = UserRepository::class;
    }

    /**
     * Display a listing of the User.
     *
     * @return Response
     */
    public function index(UserDataTable $userDataTable)
    {
        return $userDataTable->render('base.users.index');
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.users.create')->with($this->getOptionItems())->with('roles', $this->listRoles());
    }

    /**
     * Store a newly created User in storage.
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        $input = $request->all();

        $user = $this->getRepositoryObj()->create($input);

        Flash::success('User saved successfully.');

        return redirect(route('base.users.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = $this->getRepositoryObj()->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('base.users.index'));
        }

        return view('base.users.show')->with(['user' => $user, 'roles' => $this->listRoles()]);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->getRepositoryObj()->with(['employee'])->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('base.users.index'));
        }
        $optionItems = $this->getOptionItems();
        if($user->employee){
            $optionItems['employeeItems'] = [$user->employee_id => $user->employee->full_name .'('.$user->employee->code.')']; 
        } 
        
        return view('base.users.edit')->with($optionItems)->with(['user' => $user, 'roles' => $this->listRoles()]);
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        $user = $this->getRepositoryObj()->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('base.users.index'));
        }

        $user = $this->getRepositoryObj()->update($request->all(), $id);

        Flash::success('User updated successfully.');

        return redirect(route('base.users.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->getRepositoryObj()->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('base.users.index'));
        }

        $this->getRepositoryObj()->delete($id);

        Flash::success('User deleted successfully.');

        return redirect(route('base.users.index'));
    }

    private function listRoles()
    {
        $app = app();
        $roles = new RoleRepository($app);

        return $roles->all();
    }

    /**
     * Provide options item based on relationship model Entity from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        return [
            'employeeItems' => []
        ];
    }
}
