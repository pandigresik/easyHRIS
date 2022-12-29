<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Employee;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Base\DepartmentRepository;
use App\Repositories\Hr\EmployeeRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class EmployeeSupervisorDataTable extends DataTable
{        
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'department_id' => \App\DataTables\FilterClass\InKeyword::class,
        'supervisor_id' => \App\DataTables\FilterClass\InKeyword::class,
        'joblevel_id' => \App\DataTables\FilterClass\InKeyword::class,
        'jobtitle_id' => \App\DataTables\FilterClass\InKeyword::class,        
    ];
    
    private $mapColumnSearch = [
        //'entity.name' => 'entity_id',
    ];

    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);
        if (!empty($this->columnFilterOperator)) {
            foreach ($this->columnFilterOperator as $column => $operator) {
                $columnSearch = $this->mapColumnSearch[$column] ?? $column;
                $dataTable->filterColumn($column, new $operator($columnSearch));                
            }
        }
        $dataTable->editColumn('supervisor_id', function($item){            
            return $item->supervisorEmployee->codeName ?? '';
        });
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
    {
        return $model->with(['joblevel', 'jobtitle', 'company', 'department', 'supervisorEmployee'])->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $buttons = [
                    [
                       'extend' => 'create',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-gear"></i> ' .__('auth.app.setup').''
                    ],
                    [
                       'extend' => 'export',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-download"></i> ' .__('auth.app.export').''
                    ],
                    [
                       'extend' => 'print',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-print"></i> ' .__('auth.app.print').''
                    ],
                    [
                       'extend' => 'reset',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-undo"></i> ' .__('auth.app.reset').''
                    ],
                    [
                       'extend' => 'reload',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-refresh"></i> ' .__('auth.app.reload').''
                    ],
                ];
                
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'defaultContent' => '','title' => __('crud.action')])
            ->parameters([
                'dom'       => '<"row" <"col-md-6"B><"col-md-6 text-end"l>>rtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => $buttons,
                 'language' => [
                   'url' => url('vendor/datatables/i18n/en-gb.json'),
                 ],
                 'responsive' => true,
                 'fixedHeader' => true,
                 'orderCellsTop' => true     
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        $departmentRepository = new DepartmentRepository();
        $joblevelRepository = new JobLevelRepository();
        $jobtitleRepository = new JobTitleRepository();        
        $supervisorRepository = new EmployeeRepository();
        $departmentItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.department_id'), 'value' => '']], convertArrayPairValueWithKey($departmentRepository->pluck()));
        $joblevelItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.joblevel_id'), 'value' => '']], convertArrayPairValueWithKey($joblevelRepository->pluck()));
        $jobtitleItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.jobtitle_id'), 'value' => '']], convertArrayPairValueWithKey($jobtitleRepository->pluck()));        
        $supervisorItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.jobtitle_id'), 'value' => '']], convertArrayPairValueWithKey($supervisorRepository->allQuery()->supervisor()->get()->pluck('codeName','id')->toArray()));
        
        return [
            'code' => new Column(['title' => __('models/employees.fields.code'),'name' => 'code', 'data' => 'code', 'searchable' => true, 'elmsearch' => 'text']),
            'full_name' => new Column(['title' => __('models/employees.fields.full_name'),'name' => 'full_name', 'data' => 'full_name', 'searchable' => true, 'elmsearch' => 'text']),            
            'supervisor_id' => new Column(['title' => __('models/employees.fields.supervisor_id'),'name' => 'supervisor_id', 'data' => 'supervisor_id', 'defaultContent' => '' ,'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $supervisorItem, 'multiple' => 'multiple', 'width' => '200px']),
            'department_id' => new Column(['title' => __('models/employees.fields.department_id'),'name' => 'department_id', 'data' => 'department.name','defaultContent' => '-', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $departmentItem, 'multiple' => 'multiple', 'width' => '200px']),            
            'joblevel_id' => new Column(['title' => __('models/employees.fields.joblevel_id'),'name' => 'joblevel_id', 'data' => 'joblevel.name','defaultContent' => '-', 'searchable' => true, 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $joblevelItem, 'multiple' => 'multiple', 'width' => '200px']),
            'jobtitle_id' => new Column(['title' => __('models/employees.fields.jobtitle_id'),'name' => 'jobtitle_id', 'data' => 'jobtitle.name','defaultContent' => '-', 'searchable' => true, 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $jobtitleItem, 'multiple' => 'multiple', 'width' => '200px']),            
            'join_date' => new Column(['title' => __('models/employees.fields.join_date'),'name' => 'join_date', 'data' => 'join_date', 'searchable' => true, 'elmsearch' => 'daterange']),            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'employees_datatable_' . time();
    }
}
