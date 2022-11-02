<?php

namespace App\DataTables\Hr;

use App\Models\Hr\PayrollDetail;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class PayrollDetailDataTable extends DataTable
{
    private $payrollId;
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
        return $dataTable->addColumn('action', 'hr.payroll_details.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PayrollDetail $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PayrollDetail $model)
    {
        if($this->getPayrollId()){
            return $model->with(['component'])->where(['payroll_id' => $this->getPayrollId()])->newQuery();
        }
        return $model->with(['component'])->newQuery();
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
                       'extend' => 'export',
                       'className' => 'btn btn-default btn-sm no-corner',
                       'text' => '<i class="fa fa-download"></i> ' .__('auth.app.export').''
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
                 'pageLength' => 25,
                 'lengthMenu' => [ 25, 50, 75, 100 ],
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
            'component_id' => new Column(['title' => __('models/payrollDetails.fields.component_id'),'name' => 'component_id', 'data' => 'component.name', 'searchable' => false, 'elmsearch' => 'text']),
            'benefit_value' => new Column(['title' => __('models/payrollDetails.fields.benefit_value'),'name' => 'benefit_value', 'data' => 'benefit_value', 'searchable' => false, 'class' => 'text-end','elmsearch' => 'text']), 
            'description' => new Column(['title' => __('models/payrollDetails.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => false]),            
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'payroll_details_datatable_' . time();
    }

    /**
     * Get the value of payrollId
     */ 
    public function getPayrollId()
    {
        return $this->payrollId;
    }

    /**
     * Set the value of payrollId
     *
     * @return  self
     */ 
    public function setPayrollId($payrollId)
    {
        $this->payrollId = $payrollId;

        return $this;
    }
}
