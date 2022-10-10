<?php

namespace App\DataTables\Accounting;

use App\Models\Accounting\Tax;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class TaxDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'accounting.taxes.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Tax $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tax $model)
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
            'period_id' => new Column(['title' => __('models/taxes.fields.period_id'),'name' => 'period_id', 'data' => 'period_id', 'searchable' => true, 'elmsearch' => 'text']),
            'employee_id' => new Column(['title' => __('models/taxes.fields.employee_id'),'name' => 'employee_id', 'data' => 'employee_id', 'searchable' => true, 'elmsearch' => 'text']),
            'tax_group' => new Column(['title' => __('models/taxes.fields.tax_group'),'name' => 'tax_group', 'data' => 'tax_group', 'searchable' => true, 'elmsearch' => 'text']),
            'untaxable' => new Column(['title' => __('models/taxes.fields.untaxable'),'name' => 'untaxable', 'data' => 'untaxable', 'searchable' => true, 'elmsearch' => 'text']),
            'taxable' => new Column(['title' => __('models/taxes.fields.taxable'),'name' => 'taxable', 'data' => 'taxable', 'searchable' => true, 'elmsearch' => 'text']),
            'tax_value' => new Column(['title' => __('models/taxes.fields.tax_value'),'name' => 'tax_value', 'data' => 'tax_value', 'searchable' => true, 'elmsearch' => 'text']),
            'tax_key' => new Column(['title' => __('models/taxes.fields.tax_key'),'name' => 'tax_key', 'data' => 'tax_key', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'taxes_datatable_' . time();
    }
}
