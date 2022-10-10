<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Overtime;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class OvertimeDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'hr.overtimes.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Overtime $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Overtime $model)
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
            'employee_id' => new Column(['title' => __('models/overtimes.fields.employee_id'),'name' => 'employee_id', 'data' => 'employee_id', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_id' => new Column(['title' => __('models/overtimes.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment_id', 'searchable' => true, 'elmsearch' => 'text']),
            'approved_by_id' => new Column(['title' => __('models/overtimes.fields.approved_by_id'),'name' => 'approved_by_id', 'data' => 'approved_by_id', 'searchable' => true, 'elmsearch' => 'text']),
            'overtime_date' => new Column(['title' => __('models/overtimes.fields.overtime_date'),'name' => 'overtime_date', 'data' => 'overtime_date', 'searchable' => true, 'elmsearch' => 'text']),
            'start_hour' => new Column(['title' => __('models/overtimes.fields.start_hour'),'name' => 'start_hour', 'data' => 'start_hour', 'searchable' => true, 'elmsearch' => 'text']),
            'end_hour' => new Column(['title' => __('models/overtimes.fields.end_hour'),'name' => 'end_hour', 'data' => 'end_hour', 'searchable' => true, 'elmsearch' => 'text']),
            'raw_value' => new Column(['title' => __('models/overtimes.fields.raw_value'),'name' => 'raw_value', 'data' => 'raw_value', 'searchable' => true, 'elmsearch' => 'text']),
            'calculated_value' => new Column(['title' => __('models/overtimes.fields.calculated_value'),'name' => 'calculated_value', 'data' => 'calculated_value', 'searchable' => true, 'elmsearch' => 'text']),
            'holiday' => new Column(['title' => __('models/overtimes.fields.holiday'),'name' => 'holiday', 'data' => 'holiday', 'searchable' => true, 'elmsearch' => 'text']),
            'overday' => new Column(['title' => __('models/overtimes.fields.overday'),'name' => 'overday', 'data' => 'overday', 'searchable' => true, 'elmsearch' => 'text']),
            'description' => new Column(['title' => __('models/overtimes.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'overtimes_datatable_' . time();
    }
}
