<?php

namespace App\DataTables\Hr;

use App\Models\Hr\RequestWorkshift;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class RequestWorkshiftDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'hr.request_workshifts.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RequestWorkshift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RequestWorkshift $model)
    {
        return $model->employeeDescendants()->select([$model->getTable().'.*'])->with(['employee', 'shiftment'])->newQuery();
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
                'stateSave' => false,
                'order'     => [[3, 'desc'], [1, 'asc']],
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
            'employee_id' => new Column(['title' => __('models/attendances.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'employee_code' => new Column(['title' => __('models/attendances.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_id' => new Column(['title' => __('models/requestWorkshifts.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'searchable' => true, 'elmsearch' => 'text']),
            // 'shiftment_id_origin' => new Column(['title' => __('models/requestWorkshifts.fields.shiftment_id_origin'),'name' => 'shiftment_id_origin', 'data' => 'shiftment_id_origin', 'searchable' => true, 'elmsearch' => 'text']),
            'work_date' => new Column(['title' => __('models/requestWorkshifts.fields.work_date'),'name' => 'work_date', 'data' => 'work_date', 'searchable' => true, 'elmsearch' => 'text']),
            'start_hour' => new Column(['title' => __('models/workshifts.fields.start_hour'),'name' => 'start_hour', 'data' => 'start_hour', 'searchable' => false]),
            'end_hour' => new Column(['title' => __('models/workshifts.fields.end_hour'),'name' => 'end_hour', 'data' => 'end_hour', 'searchable' => false]),
            'status' => new Column(['title' => __('models/requestWorkshifts.fields.status'),'name' => 'status', 'data' => 'status', 'searchable' => true, 'elmsearch' => 'false']),
            'description' => new Column(['title' => __('models/requestWorkshifts.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'request_workshifts_datatable_' . time();
    }
}
