<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\CustomersDataTable;

use App\Http\Requests\Base\CreateCustomersRequest;
use App\Http\Requests\Base\UpdateCustomersRequest;
use App\Repositories\Base\CustomersRepository;
use App\Repositories\Base\UserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class CustomersController extends AppBaseController
{
    /** @var  CustomersRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = CustomersRepository::class;
    }

    /**
     * Display a listing of the Customers.
     *
     * @param CustomersDataTable $customersDataTable
     * @return Response
     */
    public function index(CustomersDataTable $customersDataTable)
    {
        return $customersDataTable->render('base.customers.index');
    }

    /**
     * Show the form for creating a new Customers.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.customers.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Customers in storage.
     *
     * @param CreateCustomersRequest $request
     *
     * @return Response
     */
    public function store(CreateCustomersRequest $request)
    {
        $input = $request->all();

        $customers = $this->getRepositoryObj()->create($input);

        Flash::success(__('messages.saved', ['model' => __('models/customers.singular')]));

        return redirect(route('base.customers.index'));
    }

    /**
     * Display the specified Customers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $customers = $this->getRepositoryObj()->find($id);

        if (empty($customers)) {
            Flash::error(__('models/customers.singular').' '.__('messages.not_found'));

            return redirect(route('base.customers.index'));
        }

        return view('base.customers.show')->with('customers', $customers);
    }

    /**
     * Show the form for editing the specified Customers.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $customers = $this->getRepositoryObj()->find($id);

        if (empty($customers)) {
            Flash::error(__('messages.not_found', ['model' => __('models/customers.singular')]));

            return redirect(route('base.customers.index'));
        }

        return view('base.customers.edit')->with('customers', $customers)->with($this->getOptionItems());
    }

    /**
     * Update the specified Customers in storage.
     *
     * @param  int              $id
     * @param UpdateCustomersRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCustomersRequest $request)
    {
        $customers = $this->getRepositoryObj()->find($id);

        if (empty($customers)) {
            Flash::error(__('messages.not_found', ['model' => __('models/customers.singular')]));

            return redirect(route('base.customers.index'));
        }

        $customers = $this->getRepositoryObj()->update($request->all(), $id);

        Flash::success(__('messages.updated', ['model' => __('models/customers.singular')]));

        return redirect(route('base.customers.index'));
    }

    /**
     * Remove the specified Customers from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $customers = $this->getRepositoryObj()->find($id);

        if (empty($customers)) {
            Flash::error(__('messages.not_found', ['model' => __('models/customers.singular')]));

            return redirect(route('base.customers.index'));
        }

        $this->getRepositoryObj()->delete($id);

        Flash::success(__('messages.deleted', ['model' => __('models/customers.singular')]));

        return redirect(route('base.customers.index'));
    }

    /**
     * Provide options item based on relationship model Customers from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $user = new UserRepository();
        return [
            'userItems' => ['' => __('crud.option.user_placeholder')] + $user->pluck()
        ];
    }
}
