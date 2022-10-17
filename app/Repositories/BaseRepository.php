<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

abstract class BaseRepository
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * @var Application
     */
    protected $app;

    /**
     *  @var array
     */
    protected $with = [];

    /**
     *  @var array
     */
    protected $lookupColumnSelect = ['id' => 'id', 'text' => 'name'];

    protected $filter = [];
    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->makeModel();
    }

    /**
     * Get searchable fields array.
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * Configure the Model.
     *
     * @return string
     */
    abstract public function model();

    /**
     * Make Model instance.
     *
     * @throws \Exception
     *
     * @return Model
     */
    public function makeModel()
    {
        $model = App::make($this->model());

        if (!$model instanceof Model) {
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        }

        return $this->model = $model;
    }

    /**
     * Paginate records for scaffold.
     *
     * @param int   $perPage
     * @param array $columns
     * @param mixed $currentPage
     * @param mixed $search
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($perPage, $currentPage = 1, $columns = ['*'], $search = [])
    {
        $query = $this->allQuery();
        if (!empty($search)) {
            $query->search($search['keyword'], $search['column']);
        }

        if($this->getFilter()){
            $query->where($this->getFilter());
        }

        return $query->simplePaginate($perPage, $columns, 'page', $currentPage);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array    $search
     * @param null|int $skip
     * @param null|int $limit
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null)
    {
        $query = $this->model->newQuery();

        if (!empty($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $query->search($value, [$key]);
                }
            }
        }

        if (!is_null($skip)) {
            $query->skip($skip);
        }

        if (!is_null($limit)) {
            $query->limit($limit);
        }

        return $query;
    }

    /**
     * Retrieve all records with given filter criteria.
     *
     * @param array    $search
     * @param null|int $skip
     * @param null|int $limit
     * @param array    $columns
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'])
    {
        $this->eagerLoadRelations();
        $query = $this->allQuery($search, $skip, $limit);

        return $query->get($columns);
    }

    /**
     * Create model record.
     *
     * @param array $input
     *
     * @return Model
     */
    public function create($input)
    {
        try {
            $model = $this->model->newInstance($input);
            $model->save();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }        
    }

    /**
     * Find model record for given id.
     *
     * @param int   $id
     * @param array $columns
     *
     * @return null|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function find($id, $columns = ['*'])
    {
        $this->eagerLoadRelations();
        $query = $this->model->newQuery();

        return $query->find($id, $columns);
    }

    /**
     * Update model record for given id.
     *
     * @param array $input
     * @param int   $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|Model
     */
    public function update($input, $id)
    {
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            $model->fill($input);
            $model->save();
            return $model;
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * @param int $id
     *
     * @throws \Exception
     *
     * @return null|bool|mixed
     */
    public function delete($id)
    {
        try{
            $query = $this->model->newQuery();
            $model = $query->findOrFail($id);
            return $model->delete();
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Retrieve all records with given filter criteria.
     *
     * @param array      $search
     * @param null|int   $skip
     * @param null|int   $limit
     * @param array      $columns
     * @param null|mixed $key
     * @param null|mixed $value
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function pluck($search = [], $skip = null, $limit = null, $key = null, $value = null)
    {
        $key = $key ?? $this->model->getKeyName();
        $value = $value ?? $this->model->getShowColumnOption();
        $query = $this->allQuery($search, $skip, $limit);

        return $query->pluck($value, $key)->toArray();
    }

    /**
     * Get the value of lookupColumnSelect.
     *
     * @return array
     */
    public function getLookupColumnSelect()
    {
        return $this->lookupColumnSelect;
    }

    /**
     * Set the value of lookupColumnSelect.
     *
     * @return self
     */
    public function setLookupColumnSelect(array $lookupColumnSelect)
    {
        $this->lookupColumnSelect = $lookupColumnSelect;

        return $this;
    }

    public function with($relations)
    {
        if (is_string($relations)) {
            $relations = func_get_args();
        }

        $this->with = $relations;

        return $this;
    }

    /**
     * Set the value of model.
     *
     * @return self
     */
    public function setModel(Model $model)
    {
        $this->model = $model;

        return $this;
    }

    protected function eagerLoadRelations()
    {
        if (!is_null($this->with)) {
            foreach ($this->with as $relation) {
                $this->model->with($relation);
            }
        }

        return $this;
    }

    /**
     * Get the value of filter
     */ 
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Set the value of filter
     *
     * @return  self
     */ 
    public function setFilter($filter)
    {
        $this->filter = $filter;

        return $this;
    }
}
