<?php

namespace App\Http\Controllers\Base;

use App\DataTables\Base\CompanyDataTable;

use App\Http\Requests\Base\CreateCompanyRequest;
use App\Http\Requests\Base\UpdateCompanyRequest;
use App\Repositories\Base\CompanyRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Exception;

class CompanyController extends AppBaseController
{
    /** @var  CompanyRepository */
    protected $repository;

    public function __construct()
    {
        $this->repository = CompanyRepository::class;
    }

    /**
     * Display a listing of the Company.
     *
     * @param CompanyDataTable $companyDataTable
     * @return Response
     */
    public function index(CompanyDataTable $companyDataTable)
    {
        return $companyDataTable->render('base.companies.index');
    }

    /**
     * Show the form for creating a new Company.
     *
     * @return Response
     */
    public function create()
    {
        return view('base.companies.create')->with($this->getOptionItems());
    }

    /**
     * Store a newly created Company in storage.
     *
     * @param CreateCompanyRequest $request
     *
     * @return Response
     */
    public function store(CreateCompanyRequest $request)
    {
        $input = $request->all();

        $company = $this->getRepositoryObj()->create($input);
        if ($company instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $company->getMessage()]);
        }

        Flash::success(__('messages.saved', ['model' => __('models/companies.singular')]));

        return redirect(route('base.companies.index'));
    }

    /**
     * Display the specified Company.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $company = $this->getRepositoryObj()->find($id);

        if (empty($company)) {
            Flash::error(__('models/companies.singular').' '.__('messages.not_found'));

            return redirect(route('base.companies.index'));
        }

        return view('base.companies.show')->with('company', $company);
    }

    /**
     * Show the form for editing the specified Company.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $company = $this->getRepositoryObj()->find($id);

        if (empty($company)) {
            Flash::error(__('messages.not_found', ['model' => __('models/companies.singular')]));

            return redirect(route('base.companies.index'));
        }

        return view('base.companies.edit')->with('company', $company)->with($this->getOptionItems());
    }

    /**
     * Update the specified Company in storage.
     *
     * @param  int              $id
     * @param UpdateCompanyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCompanyRequest $request)
    {
        $company = $this->getRepositoryObj()->find($id);

        if (empty($company)) {
            Flash::error(__('messages.not_found', ['model' => __('models/companies.singular')]));

            return redirect(route('base.companies.index'));
        }

        $company = $this->getRepositoryObj()->update($request->all(), $id);
        if ($company instanceof Exception) {
            return redirect()->back()->withInput()->withErrors(['error', $company->getMessage()]);
        }

        Flash::success(__('messages.updated', ['model' => __('models/companies.singular')]));

        return redirect(route('base.companies.index'));
    }

    /**
     * Remove the specified Company from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $company = $this->getRepositoryObj()->find($id);

        if (empty($company)) {
            Flash::error(__('messages.not_found', ['model' => __('models/companies.singular')]));

            return redirect(route('base.companies.index'));
        }

        $delete = $this->getRepositoryObj()->delete($id);

        if ($delete instanceof Exception) {
            return redirect()->back()->withErrors(['error', $delete->getMessage()]);
        }

        Flash::success(__('messages.deleted', ['model' => __('models/companies.singular')]));

        return redirect(route('base.companies.index'));
    }

    /**
     * Provide options item based on relationship model Company from storage.
     *
     * @throws \Exception
     *
     * @return Response
     */
    private function getOptionItems()
    {
        $parentItems = (new CompanyRepository())->pluck();
        return [
            'parentItems' => ['' => 'Pilih '] + $parentItems
        ];
    }
}
