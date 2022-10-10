<?php

namespace App\DataTables\Hr;

use App\Models\Hr\CareerHistory;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class CareerHistoryDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'hr.career_histories.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\CareerHistory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(CareerHistory $model)
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
            'employee_id' => new Column(['title' => __('models/careerHistories.fields.employee_id'),'name' => 'employee_id', 'data' => 'employee_id', 'searchable' => true, 'elmsearch' => 'text']),
            'company_id' => new Column(['title' => __('models/careerHistories.fields.company_id'),'name' => 'company_id', 'data' => 'company_id', 'searchable' => true, 'elmsearch' => 'text']),
            'department_id' => new Column(['title' => __('models/careerHistories.fields.department_id'),'name' => 'department_id', 'data' => 'department_id', 'searchable' => true, 'elmsearch' => 'text']),
            'joblevel_id' => new Column(['title' => __('models/careerHistories.fields.joblevel_id'),'name' => 'joblevel_id', 'data' => 'joblevel_id', 'searchable' => true, 'elmsearch' => 'text']),
            'jobtitle_id' => new Column(['title' => __('models/careerHistories.fields.jobtitle_id'),'name' => 'jobtitle_id', 'data' => 'jobtitle_id', 'searchable' => true, 'elmsearch' => 'text']),
            'supervisor_id' => new Column(['title' => __('models/careerHistories.fields.supervisor_id'),'name' => 'supervisor_id', 'data' => 'supervisor_id', 'searchable' => true, 'elmsearch' => 'text']),
            'contract_id' => new Column(['title' => __('models/careerHistories.fields.contract_id'),'name' => 'contract_id', 'data' => 'contract_id', 'searchable' => true, 'elmsearch' => 'text']),
            'description' => new Column(['title' => __('models/careerHistories.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'career_histories_datatable_' . time();
    }
}
