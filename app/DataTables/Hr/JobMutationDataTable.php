<?php

namespace App\DataTables\Hr;

use App\Models\Hr\JobMutation;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class JobMutationDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        //'name' => \App\DataTables\FilterClass\MatchKeyword::class,        
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
        return $dataTable->addColumn('action', 'hr.job_mutations.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\JobMutation $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(JobMutation $model)
    {
        return $model->newQuery();
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
                       'text' => '<i class="fa fa-plus"></i> ' .__('auth.app.create').''
                    ],
                    [
                       'extend' => 'export',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-download"></i> ' .__('auth.app.export').''
                    ],
                    [
                       'extend' => 'import',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-upload"></i> ' .__('auth.app.import').''
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
            ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
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
        return [
            'employee_id' => new Column(['title' => __('models/jobMutations.fields.employee_id'),'name' => 'employee_id', 'data' => 'employee_id', 'searchable' => true, 'elmsearch' => 'text']),
            'old_company_id' => new Column(['title' => __('models/jobMutations.fields.old_company_id'),'name' => 'old_company_id', 'data' => 'old_company_id', 'searchable' => true, 'elmsearch' => 'text']),
            'old_department_id' => new Column(['title' => __('models/jobMutations.fields.old_department_id'),'name' => 'old_department_id', 'data' => 'old_department_id', 'searchable' => true, 'elmsearch' => 'text']),
            'old_joblevel_id' => new Column(['title' => __('models/jobMutations.fields.old_joblevel_id'),'name' => 'old_joblevel_id', 'data' => 'old_joblevel_id', 'searchable' => true, 'elmsearch' => 'text']),
            'old_jobtitle_id' => new Column(['title' => __('models/jobMutations.fields.old_jobtitle_id'),'name' => 'old_jobtitle_id', 'data' => 'old_jobtitle_id', 'searchable' => true, 'elmsearch' => 'text']),
            'old_supervisor_id' => new Column(['title' => __('models/jobMutations.fields.old_supervisor_id'),'name' => 'old_supervisor_id', 'data' => 'old_supervisor_id', 'searchable' => true, 'elmsearch' => 'text']),
            'new_company_id' => new Column(['title' => __('models/jobMutations.fields.new_company_id'),'name' => 'new_company_id', 'data' => 'new_company_id', 'searchable' => true, 'elmsearch' => 'text']),
            'new_department_id' => new Column(['title' => __('models/jobMutations.fields.new_department_id'),'name' => 'new_department_id', 'data' => 'new_department_id', 'searchable' => true, 'elmsearch' => 'text']),
            'new_joblevel_id' => new Column(['title' => __('models/jobMutations.fields.new_joblevel_id'),'name' => 'new_joblevel_id', 'data' => 'new_joblevel_id', 'searchable' => true, 'elmsearch' => 'text']),
            'new_jobtitle_id' => new Column(['title' => __('models/jobMutations.fields.new_jobtitle_id'),'name' => 'new_jobtitle_id', 'data' => 'new_jobtitle_id', 'searchable' => true, 'elmsearch' => 'text']),
            'new_supervisor_id' => new Column(['title' => __('models/jobMutations.fields.new_supervisor_id'),'name' => 'new_supervisor_id', 'data' => 'new_supervisor_id', 'searchable' => true, 'elmsearch' => 'text']),
            'contract_id' => new Column(['title' => __('models/jobMutations.fields.contract_id'),'name' => 'contract_id', 'data' => 'contract_id', 'searchable' => true, 'elmsearch' => 'text']),
            'type' => new Column(['title' => __('models/jobMutations.fields.type'),'name' => 'type', 'data' => 'type', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'job_mutations_datatable_' . time();
    }
}
