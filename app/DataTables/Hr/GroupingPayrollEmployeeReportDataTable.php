<?php

namespace App\DataTables\Hr;

use App\Models\Hr\GroupingPayrollEmployeeReport;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Hr\GroupingPayrollEntityRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class GroupingPayrollEmployeeReportDataTable extends DataTable
{
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'employee.code' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'grouping_payroll_entity_id' => \App\DataTables\FilterClass\InKeyword::class,
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
        return $dataTable->addColumn('action', 'hr.grouping_payroll_employee_reports.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\GroupingPayrollEmployeeReport $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(GroupingPayrollEmployeeReport $model)
    {
        return $model->select([$model->getTable().'.*'])->with(['groupPayrollEntity', 'employee'])->newQuery();
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
    {   $groupPayrollItems = convertArrayPairValueWithKey( (new GroupingPayrollEntityRepository())->pluck());
        return [
            'employee.full_name' => new Column(['title' => __('models/groupingPayrollEmployeeReports.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'employee.code' => new Column(['title' => __('models/groupingPayrollEmployeeReports.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => true, 'elmsearch' => 'text']),
            'grouping_payroll_entity_id' => new Column(['title' => __('models/groupingPayrollEmployeeReports.fields.grouping_payroll_entity_id'),'name' => 'grouping_payroll_entity_id', 'data' => 'group_payroll_entity.name', 'defaultContent' => '', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $groupPayrollItems, 'multiple' => 'multiple'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'grouping_payroll_employee_reports_datatable_' . time();
    }
}
