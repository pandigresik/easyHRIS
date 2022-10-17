<?php

namespace App\DataTables\Hr;

use App\Models\Hr\WorkshiftGroup;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use App\Repositories\Hr\ShiftmentGroupRepository;
use App\Repositories\Hr\ShiftmentRepository;
use Yajra\DataTables\Html\Column;

class WorkshiftGroupDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'shiftment_group_id' => \App\DataTables\FilterClass\InKeyword::class,
        'shiftment_id' => \App\DataTables\FilterClass\InKeyword::class,
        'work_date' => \App\DataTables\FilterClass\BetweenKeyword::class
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
        $dataTable->editColumn('work_date', function($item){
            return localFormatDate($item->work_date);
        });
        return $dataTable->addColumn('action', 'hr.workshift_groups.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\WorkshiftGroup $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(WorkshiftGroup $model)
    {
        return $model->with(['shiftmentGroup','shiftment'])->newQuery();
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
        $shiftmentGroupRepository = new ShiftmentGroupRepository();
        $shiftmentItem = convertArrayPairValueWithKey($shiftmentRepository->pluck());
        $shiftmentGroupItem =  convertArrayPairValueWithKey($shiftmentGroupRepository->pluck());
        
        return [
            'shiftment_group_id' => new Column(['title' => __('models/workshiftGroups.fields.shiftment_group_id'),'name' => 'shiftment_group_id', 'data' => 'shiftment_group.name', 'searchable' => true, 'listItem' => $shiftmentGroupItem, 'multiple' => 'multiple',  'elmsearch' => 'dropdown']),
            'shiftment_id' => new Column(['title' => __('models/workshiftGroups.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'searchable' => true, 'listItem' => $shiftmentItem, 'multiple' => 'multiple' ,'elmsearch' => 'dropdown']),
            'work_date' => new Column(['title' => __('models/workshiftGroups.fields.work_date'),'name' => 'work_date', 'data' => 'work_date', 'searchable' => true, 'elmsearch' => 'daterange'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'workshift_groups_datatable_' . time();
    }
}
