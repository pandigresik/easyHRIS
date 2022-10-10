<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Employee;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class EmployeeDataTable extends DataTable
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
        return $dataTable->addColumn('action', 'hr.employees.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Employee $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Employee $model)
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
            'contract_id' => new Column(['title' => __('models/employees.fields.contract_id'),'name' => 'contract_id', 'data' => 'contract_id', 'searchable' => true, 'elmsearch' => 'text']),
            'company_id' => new Column(['title' => __('models/employees.fields.company_id'),'name' => 'company_id', 'data' => 'company_id', 'searchable' => true, 'elmsearch' => 'text']),
            'department_id' => new Column(['title' => __('models/employees.fields.department_id'),'name' => 'department_id', 'data' => 'department_id', 'searchable' => true, 'elmsearch' => 'text']),
            'joblevel_id' => new Column(['title' => __('models/employees.fields.joblevel_id'),'name' => 'joblevel_id', 'data' => 'joblevel_id', 'searchable' => true, 'elmsearch' => 'text']),
            'jobtitle_id' => new Column(['title' => __('models/employees.fields.jobtitle_id'),'name' => 'jobtitle_id', 'data' => 'jobtitle_id', 'searchable' => true, 'elmsearch' => 'text']),
            'supervisor_id' => new Column(['title' => __('models/employees.fields.supervisor_id'),'name' => 'supervisor_id', 'data' => 'supervisor_id', 'searchable' => true, 'elmsearch' => 'text']),
            'region_of_birth_id' => new Column(['title' => __('models/employees.fields.region_of_birth_id'),'name' => 'region_of_birth_id', 'data' => 'region_of_birth_id', 'searchable' => true, 'elmsearch' => 'text']),
            'city_of_birth_id' => new Column(['title' => __('models/employees.fields.city_of_birth_id'),'name' => 'city_of_birth_id', 'data' => 'city_of_birth_id', 'searchable' => true, 'elmsearch' => 'text']),
            'address' => new Column(['title' => __('models/employees.fields.address'),'name' => 'address', 'data' => 'address', 'searchable' => true, 'elmsearch' => 'text']),
            'join_date' => new Column(['title' => __('models/employees.fields.join_date'),'name' => 'join_date', 'data' => 'join_date', 'searchable' => true, 'elmsearch' => 'text']),
            'employee_status' => new Column(['title' => __('models/employees.fields.employee_status'),'name' => 'employee_status', 'data' => 'employee_status', 'searchable' => true, 'elmsearch' => 'text']),
            'code' => new Column(['title' => __('models/employees.fields.code'),'name' => 'code', 'data' => 'code', 'searchable' => true, 'elmsearch' => 'text']),
            'full_name' => new Column(['title' => __('models/employees.fields.full_name'),'name' => 'full_name', 'data' => 'full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'gender' => new Column(['title' => __('models/employees.fields.gender'),'name' => 'gender', 'data' => 'gender', 'searchable' => true, 'elmsearch' => 'text']),
            'date_of_birth' => new Column(['title' => __('models/employees.fields.date_of_birth'),'name' => 'date_of_birth', 'data' => 'date_of_birth', 'searchable' => true, 'elmsearch' => 'text']),
            'identity_number' => new Column(['title' => __('models/employees.fields.identity_number'),'name' => 'identity_number', 'data' => 'identity_number', 'searchable' => true, 'elmsearch' => 'text']),
            'identity_type' => new Column(['title' => __('models/employees.fields.identity_type'),'name' => 'identity_type', 'data' => 'identity_type', 'searchable' => true, 'elmsearch' => 'text']),
            'marital_status' => new Column(['title' => __('models/employees.fields.marital_status'),'name' => 'marital_status', 'data' => 'marital_status', 'searchable' => true, 'elmsearch' => 'text']),
            'email' => new Column(['title' => __('models/employees.fields.email'),'name' => 'email', 'data' => 'email', 'searchable' => true, 'elmsearch' => 'text']),
            'leave_balance' => new Column(['title' => __('models/employees.fields.leave_balance'),'name' => 'leave_balance', 'data' => 'leave_balance', 'searchable' => true, 'elmsearch' => 'text']),
            'tax_group' => new Column(['title' => __('models/employees.fields.tax_group'),'name' => 'tax_group', 'data' => 'tax_group', 'searchable' => true, 'elmsearch' => 'text']),
            'resign_date' => new Column(['title' => __('models/employees.fields.resign_date'),'name' => 'resign_date', 'data' => 'resign_date', 'searchable' => true, 'elmsearch' => 'text']),
            'have_overtime_benefit' => new Column(['title' => __('models/employees.fields.have_overtime_benefit'),'name' => 'have_overtime_benefit', 'data' => 'have_overtime_benefit', 'searchable' => true, 'elmsearch' => 'text']),
            'risk_ratio' => new Column(['title' => __('models/employees.fields.risk_ratio'),'name' => 'risk_ratio', 'data' => 'risk_ratio', 'searchable' => true, 'elmsearch' => 'text']),
            'profile_image' => new Column(['title' => __('models/employees.fields.profile_image'),'name' => 'profile_image', 'data' => 'profile_image', 'searchable' => true, 'elmsearch' => 'text']),
            'profile_size' => new Column(['title' => __('models/employees.fields.profile_size'),'name' => 'profile_size', 'data' => 'profile_size', 'searchable' => true, 'elmsearch' => 'text']),
            'salary_group_id' => new Column(['title' => __('models/employees.fields.salary_group_id'),'name' => 'salary_group_id', 'data' => 'salary_group_id', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_group_id' => new Column(['title' => __('models/employees.fields.shiftment_group_id'),'name' => 'shiftment_group_id', 'data' => 'shiftment_group_id', 'searchable' => true, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'employees_datatable_' . time();
    }
}
