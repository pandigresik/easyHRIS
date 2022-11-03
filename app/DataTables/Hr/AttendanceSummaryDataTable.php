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
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,        
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
        return $model->with(['employee'])->newQuery();
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
                       'text' => '<i class="fa fa-plus"></i> ' .__('auth.app.generate').''
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
            'employee.full_name' => new Column(['title' => __('models/attendanceSummaries.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'year' => new Column(['title' => __('models/attendanceSummaries.fields.year'),'name' => 'year', 'data' => 'year', 'searchable' => true, 'elmsearch' => 'text']),
            'month' => new Column(['title' => __('models/attendanceSummaries.fields.month'),'name' => 'month', 'data' => 'month', 'searchable' => true, 'elmsearch' => 'text']),
            'total_workday' => new Column(['title' => __('models/attendanceSummaries.fields.total_workday'),'name' => 'total_workday', 'data' => 'total_workday', 'searchable' => false, 'elmsearch' => 'text']),
            'total_in' => new Column(['title' => __('models/attendanceSummaries.fields.total_in'),'name' => 'total_in', 'data' => 'total_in', 'searchable' => false, 'elmsearch' => 'text']),
            'total_leave' => new Column(['title' => __('models/attendanceSummaries.fields.total_leave'),'name' => 'total_leave', 'data' => 'total_leave', 'searchable' => false, 'elmsearch' => 'text']),
            'total_absent' => new Column(['title' => __('models/attendanceSummaries.fields.total_absent'),'name' => 'total_absent', 'data' => 'total_absent', 'searchable' => false, 'elmsearch' => 'text']),
            'total_off' => new Column(['title' => __('models/attendanceSummaries.fields.total_off'),'name' => 'total_off', 'data' => 'total_off', 'searchable' => false, 'elmsearch' => 'text'])
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
