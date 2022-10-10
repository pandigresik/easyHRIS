<?php

namespace App\DataTables\Hr;

use App\Models\Hr\AttendanceSummary;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class AttendanceSummaryDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'hr.attendance_summaries.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AttendanceSummary $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AttendanceSummary $model)
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
            'employee_id' => new Column(['title' => __('models/attendanceSummaries.fields.employee_id'),'name' => 'employee_id', 'data' => 'employee_id', 'searchable' => true, 'elmsearch' => 'text']),
            'year' => new Column(['title' => __('models/attendanceSummaries.fields.year'),'name' => 'year', 'data' => 'year', 'searchable' => true, 'elmsearch' => 'text']),
            'month' => new Column(['title' => __('models/attendanceSummaries.fields.month'),'name' => 'month', 'data' => 'month', 'searchable' => true, 'elmsearch' => 'text']),
            'total_workday' => new Column(['title' => __('models/attendanceSummaries.fields.total_workday'),'name' => 'total_workday', 'data' => 'total_workday', 'searchable' => true, 'elmsearch' => 'text']),
            'total_in' => new Column(['title' => __('models/attendanceSummaries.fields.total_in'),'name' => 'total_in', 'data' => 'total_in', 'searchable' => true, 'elmsearch' => 'text']),
            'total_loyality' => new Column(['title' => __('models/attendanceSummaries.fields.total_loyality'),'name' => 'total_loyality', 'data' => 'total_loyality', 'searchable' => true, 'elmsearch' => 'text']),
            'total_absent' => new Column(['title' => __('models/attendanceSummaries.fields.total_absent'),'name' => 'total_absent', 'data' => 'total_absent', 'searchable' => true, 'elmsearch' => 'text']),
            'total_overtime' => new Column(['title' => __('models/attendanceSummaries.fields.total_overtime'),'name' => 'total_overtime', 'data' => 'total_overtime', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'attendance_summaries_datatable_' . time();
    }
}
