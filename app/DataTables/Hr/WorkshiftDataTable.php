<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Workshift;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Hr\ShiftmentRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class WorkshiftDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [        
        'shiftment_id' => \App\DataTables\FilterClass\InKeyword::class,
        'work_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'employee.code' => \App\DataTables\FilterClass\RelationMatchKeyword::class,
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
        // $dataTable->editColumn('work_date', function($item){
        //     return localFormatDate($item->work_date);
        // })->editColumn('start_hour', function($item){
        //     return localFormatDateTime($item->start_hour);
        // })->editColumn('end_hour', function($item){
        //     return localFormatDateTime($item->end_hour);
        // });
        // $dataTable->addColumn('action', 'hr.workshifts.datatables_actions');
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Workshift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Workshift $model)
    {
        return $model->selectRaw($model->getTable().'.*')->with(['shiftment','employee'])->newQuery();
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
        $shiftmentRepository = new ShiftmentRepository();        
        $shiftmentItem = convertArrayPairValueWithKey($shiftmentRepository->pluck());
        return [
            'employee_id' => new Column(['title' => __('models/attendances.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'employee_code' => new Column(['title' => __('models/attendances.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_id' => new Column(['title' => __('models/workshifts.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment_id', 'searchable' => true, 'elmsearch' => 'text']),
            // 'description' => new Column(['title' => __('models/workshifts.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_id' => new Column(['title' => __('models/workshifts.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'searchable' => true, 'listItem' => $shiftmentItem, 'multiple' => 'multiple' ,'elmsearch' => 'dropdown']),
            'work_date' => new Column(['title' => __('models/workshifts.fields.work_date'),'name' => 'work_date', 'data' => 'work_date', 'searchable' => true, 'elmsearch' => 'daterange']),
            'start_hour' => new Column(['title' => __('models/workshifts.fields.start_hour'),'name' => 'start_hour', 'data' => 'start_hour', 'searchable' => false]),
            'end_hour' => new Column(['title' => __('models/workshifts.fields.end_hour'),'name' => 'end_hour', 'data' => 'end_hour', 'searchable' => false]),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'workshifts_datatable_' . time();
    }
}
