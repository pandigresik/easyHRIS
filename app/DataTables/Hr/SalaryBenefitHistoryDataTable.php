<?php

namespace App\DataTables\Hr;

use App\Models\Hr\SalaryBenefitHistory;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class SalaryBenefitHistoryDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'hr.salary_benefit_histories.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\SalaryBenefitHistory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(SalaryBenefitHistory $model)
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
            'employee_id' => new Column(['title' => __('models/salaryBenefitHistories.fields.employee_id'),'name' => 'employee_id', 'data' => 'employee_id', 'searchable' => true, 'elmsearch' => 'text']),
            'component_id' => new Column(['title' => __('models/salaryBenefitHistories.fields.component_id'),'name' => 'component_id', 'data' => 'component_id', 'searchable' => true, 'elmsearch' => 'text']),
            'contract_id' => new Column(['title' => __('models/salaryBenefitHistories.fields.contract_id'),'name' => 'contract_id', 'data' => 'contract_id', 'searchable' => true, 'elmsearch' => 'text']),
            'new_benefit_value' => new Column(['title' => __('models/salaryBenefitHistories.fields.new_benefit_value'),'name' => 'new_benefit_value', 'data' => 'new_benefit_value', 'searchable' => true, 'elmsearch' => 'text']),
            'old_benefit_value' => new Column(['title' => __('models/salaryBenefitHistories.fields.old_benefit_value'),'name' => 'old_benefit_value', 'data' => 'old_benefit_value', 'searchable' => true, 'elmsearch' => 'text']),
            'benefit_key' => new Column(['title' => __('models/salaryBenefitHistories.fields.benefit_key'),'name' => 'benefit_key', 'data' => 'benefit_key', 'searchable' => true, 'elmsearch' => 'text']),
            'description' => new Column(['title' => __('models/salaryBenefitHistories.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'salary_benefit_histories_datatable_' . time();
    }
}
