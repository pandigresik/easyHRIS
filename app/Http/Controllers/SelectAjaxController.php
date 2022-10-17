<?php

namespace App\Http\Controllers;

use App\DataTables\CustomersDataTable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Response;

class SelectAjaxController extends AppBaseController
{
    protected $repository;
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Display a listing of the Customers.
     *
     * @param CustomersDataTable $customersDataTable
     *
     * @return Response
     */
    public function index()
    {
        $repository = 'App\Repositories\\'.$this->request->get('repository');
        $this->repository = app()->make($repository);

        return $this->searchPaging();
    }

    private function searchPaging()
    {
        $lookupColumn = $this->repository->getLookupColumnSelect();
        $q = $this->request->get('q');
        $filter = $this->request->get('filter');
        $currentPage = $this->request->get('page') ?? 1;
        $limit = $this->request->get('limit') ?? 10;
        $data = $this->repository->setFilter($filter)->paginate($limit, $currentPage, [$lookupColumn['id'].' as id', $lookupColumn['text'].' as text'], ['keyword' => $q, 'column' => [$lookupColumn['text']]]);

        return new JsonResponse($data);
    }
}
