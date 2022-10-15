<?php

namespace App\DataTables\Hr;

use App\Models\Hr\ShiftmentSchedule;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Hr\ShiftmentRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ShiftmentScheduleDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'shiftment_id' => \App\DataTables\FilterClass\InKeyword::class,
        'work_day' => \App\DataTables\FilterClass\InKeyword::class,
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
        $dataTable->editColumn('work_day', function($item){
            $workday = listWorkDay();
            return $workday[$item->work_day] ?? 'undefined '.$item->work_day;
        });
        return $dataTable->addColumn('action', 'hr.shiftment_schedules.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ShiftmentSchedule $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ShiftmentSchedule $model)
    {
        return $model->with(['shiftment'])->newQuery();
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
        $shiftmentRepository = new ShiftmentRepository();        
        $shiftmentItems = array_merge([['text' => 'Pilih '.__('models/shifments.fields.singular'), 'value' => '']], convertArrayPairValueWithKey($shiftmentRepository->pluck()));
        $workdayItems = array_merge([['text' => 'Pilih '.__('models/shifments.fields.singular'), 'value' => '']], convertArrayPairValueWithKey(listWorkDay()));
        return [
            'shiftment_id' => new Column(['title' => __('models/shiftmentSchedules.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'defaultContent' => '-', 'searchable' => true, 'multiple' => 'multiple', 'elmsearch' => 'dropdown', 'listItem' => $shiftmentItems]),
            'work_day' => new Column(['title' => __('models/shiftmentSchedules.fields.work_day'),'name' => 'work_day', 'data' => 'work_day', 'searchable' => true, 'multiple' => 'multiple', 'elmsearch' => 'dropdown', 'listItem' => $workdayItems]),
            'start_hour' => new Column(['title' => __('models/shiftmentSchedules.fields.start_hour'),'name' => 'start_hour', 'data' => 'start_hour', 'searchable' => true, 'elmsearch' => 'text']),
            'end_hour' => new Column(['title' => __('models/shiftmentSchedules.fields.end_hour'),'name' => 'end_hour', 'data' => 'end_hour', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'shiftment_schedules_datatable_' . time();
    }
}
