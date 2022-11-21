<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Attendance;
use App\DataTables\BaseDataTable as DataTable;
use App\Models\Hr\AbsentReason;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class AttendanceDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'state' => \App\DataTables\FilterClass\InKeyword::class,
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'employee.code' => \App\DataTables\FilterClass\RelationMatchKeyword::class,
        'attendance_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
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
        // $dataTable->editColumn('employee_id', function($item){
        //     $employee = $item->employee;
            
        //     return $employee->full_name.' ('.$employee->code.')';
        // });
        return $dataTable->addColumn('action', 'hr.attendances.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Attendance $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Attendance $model)
    {
        return $model->employeeDescendants()->selectRaw($model->getTable().'.*, attendance_date as raw_attendance_date')->with(['employee', 'shiftment','reason'])->newQuery();
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
                       'text' => '<i class="fa fa-plus"></i> ' .__('auth.app.process').''
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
        $stateItem = convertArrayPairValueWithKey(Attendance::STATE + AbsentReason::pluck('code', 'code')->toArray());
        return [
            'attendance_date' => new Column(['title' => __('models/attendances.fields.attendance_date'),'name' => 'attendance_date', 'data' => 'attendance_date', 'searchable' => true, 'elmsearch' => 'daterange']),
            'employee_id' => new Column(['title' => __('models/attendances.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'employee_code' => new Column(['title' => __('models/attendances.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_id' => new Column(['title' => __('models/attendances.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'searchable' => true, 'elmsearch' => 'text']),
            'reason_id' => new Column(['title' => __('models/attendances.fields.reason_id'),'name' => 'reason_id', 'data' => 'reason.name', 'defaultContent' => '-', 'searchable' => true, 'elmsearch' => 'text']),            
            //'description' => new Column(['title' => __('models/attendances.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text']),
            //'check_in_schedule' => new Column(['title' => __('models/attendances.fields.check_in_schedule'),'name' => 'check_in_schedule', 'data' => 'check_in_schedule', 'searchable' => true, 'elmsearch' => 'text']),
            //'check_out_schedule' => new Column(['title' => __('models/attendances.fields.check_out_schedule'),'name' => 'check_out_schedule', 'data' => 'check_out_schedule', 'searchable' => true, 'elmsearch' => 'text']),
            'check_in' => new Column(['title' => __('models/attendances.fields.check_in'),'name' => 'check_in', 'data' => 'check_in', 'searchable' => false, 'elmsearch' => 'text']),
            'check_out' => new Column(['title' => __('models/attendances.fields.check_out'),'name' => 'check_out', 'data' => 'check_out', 'searchable' => false, 'elmsearch' => 'text']),
            'early_in' => new Column(['title' => __('models/attendances.fields.early_in').' (minutes)','name' => 'early_in', 'data' => 'early_in', 'searchable' => false, 'elmsearch' => 'text', 'className' => 'text-end']),
            'early_out' => new Column(['title' => __('models/attendances.fields.early_out').' (minutes)','name' => 'early_out', 'data' => 'early_out', 'searchable' => false, 'elmsearch' => 'text', 'className' => 'text-end']),
            'late_in' => new Column(['title' => __('models/attendances.fields.late_in').' (minutes)','name' => 'late_in', 'data' => 'late_in', 'searchable' => false, 'elmsearch' => 'text', 'className' => 'text-end']),
            'late_out' => new Column(['title' => __('models/attendances.fields.late_out').' (minutes)','name' => 'late_out', 'data' => 'late_out', 'searchable' => false, 'elmsearch' => 'text', 'className' => 'text-end']),
            // 'absent' => new Column(['title' => __('models/attendances.fields.absent'),'name' => 'absent', 'data' => 'absent', 'searchable' => true, 'elmsearch' => 'text']),
            'state' => new Column(['title' => __('models/attendances.fields.state'),'name' => 'state', 'data' => 'state', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $stateItem, 'multiple' => 'multiple'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'attendances_datatable_' . time();
    }
}
