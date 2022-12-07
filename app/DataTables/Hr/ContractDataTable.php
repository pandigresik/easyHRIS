<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Contract;
use App\DataTables\BaseDataTable as DataTable;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class ContractDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'start_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
        'end_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
        'signed_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
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
        $dataTable->editColumn('path_file', function($item){
            if($item->path_file){
                return '<a href="'.Storage::url('').'?path='.$item->path_file.'" target="_blank">file attachment</a>';
            }
            return null;
        })->editColumn('employee.code', function($item){
            return $item->employee->codeName;
        })->escapeColumns([]);
        return $dataTable->addColumn('action', 'hr.contracts.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Contract $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contract $model)
    {
        return $model->select([$model->getTable().'.*'])->with(['employee'])->newQuery();
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
            'letter_number' => new Column(['title' => __('models/contracts.fields.letter_number'),'name' => 'letter_number', 'data' => 'letter_number', 'searchable' => true, 'elmsearch' => 'text']),
            'subject' => new Column(['title' => __('models/contracts.fields.subject'),'name' => 'subject', 'data' => 'subject', 'searchable' => true, 'elmsearch' => 'text']),
            'employee.code' => new Column(['title' => __('models/contracts.fields.employee'),'name' => 'employee.code', 'data' => 'employee.code', 'defaultContent' => '-' , 'searchable' => false, 'elmsearch' => 'text']),
            'description' => new Column(['title' => __('models/contracts.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text']),
            'start_date' => new Column(['title' => __('models/contracts.fields.start_date'),'name' => 'start_date', 'data' => 'start_date', 'searchable' => true, 'elmsearch' => 'daterange']),
            'end_date' => new Column(['title' => __('models/contracts.fields.end_date'),'name' => 'end_date', 'data' => 'end_date', 'searchable' => true, 'elmsearch' => 'daterange']),
            'signed_date' => new Column(['title' => __('models/contracts.fields.signed_date'),'name' => 'signed_date', 'data' => 'signed_date', 'searchable' => true, 'elmsearch' => 'daterange']),
            'tags' => new Column(['title' => __('models/contracts.fields.tags'),'name' => 'tags', 'data' => 'tags', 'searchable' => true, 'elmsearch' => 'text']),
            // 'used' => new Column(['title' => __('models/contracts.fields.used'),'name' => 'used', 'data' => 'used', 'searchable' => true, 'elmsearch' => 'text']),
            'path_file' => new Column(['title' => __('models/contracts.fields.file_upload'),'name' => 'used', 'data' => 'path_file', 'searchable' => false, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'contracts_datatable_' . time();
    }
}
