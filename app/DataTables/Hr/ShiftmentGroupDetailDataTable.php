<?php

namespace App\DataTables\Hr;

use App\Models\Hr\ShiftmentGroupDetail;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Hr\ShiftmentGroupRepository;
use App\Repositories\Hr\ShiftmentRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ShiftmentGroupDetailDataTable extends DataTable
{
    private $shiftmentGroup;
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
        return $dataTable->addColumn('action', 'hr.shiftment_group_details.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ShiftmentGroupDetail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(ShiftmentGroupDetail $model)
    {
        if(!empty($this->getShiftmentGroup())){
            return $model->where(['shiftment_group_id' => $this->getShiftmentGroup()])->with(['shiftmentGroup','shiftment'])->newQuery();
        }
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
        $shiftmentItem = array_merge([['text' => 'Pilih '.__('models/shifments.fields.singular'), 'value' => '']], convertArrayPairValueWithKey($shiftmentRepository->pluck()));
        $shiftmentGroupItem = array_merge([['text' => 'Pilih '.__('models/shifments.fields.singular'), 'value' => '']], convertArrayPairValueWithKey($shiftmentGroupRepository->pluck()));
        return [
            'shiftment_group_id' => new Column(['title' => __('models/shiftmentGroupDetails.fields.shiftment_group_id'),'name' => 'shiftment_group_id', 'data' => 'shiftment_group.name', 'searchable' => true, 'listItem' => $shiftmentGroupItem,  'elmsearch' => 'dropdown']),
            'shiftment_id' => new Column(['title' => __('models/shiftmentGroupDetails.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'searchable' => true, 'listItem' => $shiftmentItem ,'elmsearch' => 'dropdown']),
            'sequence' => new Column(['title' => __('models/shiftmentGroupDetails.fields.sequence'),'name' => 'sequence', 'data' => 'sequence', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'shiftment_group_details_datatable_' . time();
    }

    /**
     * Get the value of shiftmentGroup
     */ 
    public function getShiftmentGroup()
    {
        return $this->shiftmentGroup;
    }

    /**
     * Set the value of shiftmentGroup
     *
     * @return  self
     */ 
    public function setShiftmentGroup($shiftmentGroup)
    {
        $this->shiftmentGroup = $shiftmentGroup;

        return $this;
    }
}
