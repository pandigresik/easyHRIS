<?php

namespace App\DataTables\Hr;

use App\Models\Hr\PayrollPeriod;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class PayrollPeriodDataTable extends DataTable
{
    protected $typePeriod;
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
        return $dataTable->addColumn('action', 'hr.payroll_periods.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PayrollPeriod $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PayrollPeriod $model)
    {
        if($this->getTypePeriod()){
            return $model->where(['type_period' => $this->getTypePeriod()])->newQuery();    
        }
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
        return [
            'company_id' => new Column(['title' => __('models/payrollPeriods.fields.company_id'),'name' => 'company_id', 'data' => 'company_id', 'searchable' => true, 'elmsearch' => 'text']),
            'name' => new Column(['title' => __('models/payrollPeriods.fields.name'),'name' => 'name', 'data' => 'name', 'searchable' => true, 'elmsearch' => 'text']),
            'year' => new Column(['title' => __('models/payrollPeriods.fields.year'),'name' => 'year', 'data' => 'year', 'searchable' => true, 'elmsearch' => 'text']),
            'month' => new Column(['title' => __('models/payrollPeriods.fields.month'),'name' => 'month', 'data' => 'month', 'searchable' => true, 'elmsearch' => 'text']),
            'start_period' => new Column(['title' => __('models/payrollPeriods.fields.start_period'),'name' => 'start_period', 'data' => 'start_period', 'searchable' => true, 'elmsearch' => 'text']),
            'end_period' => new Column(['title' => __('models/payrollPeriods.fields.end_period'),'name' => 'end_period', 'data' => 'end_period', 'searchable' => true, 'elmsearch' => 'text']),
            'closed' => new Column(['title' => __('models/payrollPeriods.fields.closed'),'name' => 'closed', 'data' => 'closed', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'payroll_periods_datatable_' . time();
    }

    /**
     * Get the value of typePeriod
     */ 
    public function getTypePeriod()
    {
        return $this->typePeriod;
    }

    /**
     * Set the value of typePeriod
     *
     * @return  self
     */ 
    public function setTypePeriod($typePeriod)
    {
        $this->typePeriod = $typePeriod;

        return $this;
    }
}
