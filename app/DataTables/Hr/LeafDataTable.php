<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Leaf;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Hr\AbsentReasonRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class LeafDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'leave_start' => \App\DataTables\FilterClass\BetweenKeyword::class,
        'leave_end' => \App\DataTables\FilterClass\BetweenKeyword::class,
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
        $dataTable->editColumn('leave_start', function($item){
            return localFormatDateTime($item->leave_start);
        })->editColumn('leave_end', function($item){
            return localFormatDateTime($item->leave_end);
        });
        return $dataTable->addColumn('action', 'hr.leaves.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Leaf $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Leaf $model)
    {
        return $model->selectRaw($model->getTable().'.*')->with(['employee', 'reason'])->newQuery();
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
        $reasonRepository = new AbsentReasonRepository();        
        $reasonItems = convertArrayPairValueWithKey($reasonRepository->pluck());
        
        return [
            'employee.full_name' => new Column(['title' => __('models/leaves.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'reason_id' => new Column(['title' => __('models/leaves.fields.reason_id'),'name' => 'reason_id', 'data' => 'reason.name', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $reasonItems, 'multiple' => 'multiple']),
            'leave_start' => new Column(['title' => __('models/leaves.fields.leave_start'),'name' => 'leave_start', 'data' => 'leave_start', 'searchable' => true, 'elmsearch' => 'daterange']),
            'leave_end' => new Column(['title' => __('models/leaves.fields.leave_end'),'name' => 'leave_end', 'data' => 'leave_end', 'searchable' => true, 'elmsearch' => 'daterange']),
            'amount' => new Column(['title' => __('models/leaves.fields.amount'),'name' => 'amount', 'data' => 'amount', 'searchable' => false, 'elmsearch' => 'text']),
            // 'status' => new Column(['title' => __('models/leaves.fields.status'),'name' => 'status', 'data' => 'status', 'searchable' => false, 'elmsearch' => 'text']),
            // 'step_approval' => new Column(['title' => __('models/leaves.fields.step_approval'),'name' => 'step_approval', 'data' => 'step_approval', 'searchable' => false, 'elmsearch' => 'text']),
            // 'amount_approval' => new Column(['title' => __('models/leaves.fields.amount_approval'),'name' => 'amount_approval', 'data' => 'amount_approval', 'searchable' => false, 'elmsearch' => 'text']),
            'description' => new Column(['title' => __('models/leaves.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => false, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'leaves_datatable_' . time();
    }
}
