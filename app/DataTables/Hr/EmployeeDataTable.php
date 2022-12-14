<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Employee;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Base\BusinessUnitRepository;
use App\Repositories\Base\DepartmentRepository;
use App\Repositories\Hr\JobLevelRepository;
use App\Repositories\Hr\JobTitleRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class EmployeeDataTable extends DataTable
{
    protected $fastExcel = false;
    protected $exportColumns = [        
        ['data' => 'company.name', 'defaultContent' => '','title' => 'company_id'],
        ['data' => 'code', 'defaultContent' => '','title' => 'code'],
        ['data' => 'full_name', 'defaultContent' => '','title' => 'full_name'],
        ['data' => 'business_unit.name', 'defaultContent' => '','title' => 'business_unit_id'],
        ['data' => 'department.name', 'defaultContent' => '','title' => 'department_id'],                
        ['data' => 'jobtitle.name', 'defaultContent' => '','title' => 'jobtitle_id'],
        ['data' => 'employee_status', 'defaultContent' => '','title' => 'employee_status'],
        ['data' => 'salary', 'defaultContent' => '','title' => 'salary'],
        ['data' => 'overtime', 'defaultContent' => '','title' => 'overtime'],
        ['data' => 'position_allowance', 'defaultContent' => '','title' => 'position_allowance'],
        ['data' => 'bpjs_kesehatan', 'defaultContent' => '','title' => 'bpjs_kesehatan'],
        ['data' => 'bpjs_jht', 'defaultContent' => '','title' => 'bpjs_jht'],
        ['data' => 'bpjs_jp', 'defaultContent' => '','title' => 'bpjs_jp'], 
        ['data' => 'premi_kehadiran', 'defaultContent' => '','title' => 'premi_kehadiran'], 
        ['data' => 'uang_makan', 'defaultContent' => '','title' => 'uang_makan'],
        ['data' => 'tunjangan_minggu', 'defaultContent' => '','title' => 'tunjangan_minggu'],
        ['data' => 'joblevel.name', 'defaultContent' => '','title' => 'joblevel_id'],
        ['data' => 'supervisor_id', 'defaultContent' => '','title' => 'supervisor_id'],        
        ['data' => 'have_overtime_benefit', 'defaultContent' => '','title' => 'have_overtime_benefit'],
        ['data' => 'contract_id', 'defaultContent' => '','title' => 'contract_id'],
        ['data' => 'region_of_birth_id', 'defaultContent' => '','title' => 'region_of_birth_id'],
        ['data' => 'city_of_birth_id', 'defaultContent' => '','title' => 'city_of_birth_id'],
        ['data' => 'address', 'defaultContent' => '','title' => 'address'],
        ['data' => 'join_date', 'defaultContent' => '','title' => 'join_date'],                
        ['data' => 'gender', 'defaultContent' => '','title' => 'gender'],
        ['data' => 'date_of_birth', 'defaultContent' => '','title' => 'date_of_birth'],
        ['data' => 'identity_number', 'defaultContent' => '','title' => 'identity_number'],
        ['data' => 'identity_type', 'defaultContent' => '','title' => 'identity_type'],
        ['data' => 'account_bank', 'defaultContent' => '','title' => 'account_bank'],
        ['data' => 'marital_status', 'defaultContent' => '','title' => 'marital_status'],
        ['data' => 'email', 'defaultContent' => '','title' => 'email'],
        ['data' => 'leave_balance', 'defaultContent' => '','title' => 'leave_balance'],                                
        ['data' => 'salary_group.name', 'defaultContent' => '','title' => 'salary_group_id'],
        ['data' => 'shiftment_group.name', 'defaultContent' => '','title' => 'shiftment_group_id'],
        ['data' => 'payroll_period_group.name', 'defaultContent' => '','title' => 'payroll_period_group_id']        
    ];
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'department_id' => \App\DataTables\FilterClass\InKeyword::class,
        'business_unit_id' => \App\DataTables\FilterClass\InKeyword::class,
        'joblevel_id' => \App\DataTables\FilterClass\InKeyword::class,
        'jobtitle_id' => \App\DataTables\FilterClass\InKeyword::class,        
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
        $dataTable->editColumn('join_date', function($data){
            if($this->request()->get('action') == 'excel'){
                return $data->getRawOriginal('join_date');
            }
            return $data->join_date;
        });
        $dataTable->editColumn('date_of_birth', function($data){
            if($this->request()->get('action') == 'excel'){
                return $data->getRawOriginal('date_of_birth');
            }
            return $data->date_of_birth;
        });
        $dataTable->editColumn('resign_date', function($data){
            if($this->request()->get('action') == 'excel'){
                return $data->getRawOriginal('resign_date');
            }
            return $data->resign_date;
        });
        $dataTable->editColumn('overtime', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'OT')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('salary', function ($data) {
            $item = $data->salaryBenefits->whereIn('component.code', ['GP', 'GPH'])->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('position_allowance', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'TJ')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('bpjs_kesehatan', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'PJKNM')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('bpjs_jht', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'JHTM')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('bpjs_jp', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'JPM')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('uang_makan', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'UM')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('premi_kehadiran', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'PRHD')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
        $dataTable->editColumn('tunjangan_minggu', function ($data) {
            $item = $data->salaryBenefits->where('component.code', 'TUMLM')->first();
            return $item ? $item->getRawOriginal('benefit_value') : NULL;
        });
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
        return $model->with(['joblevel', 'jobtitle', 'company', 'department','regionOfBirth', 'businessUnit', 'shiftmentGroup', 'salaryGroup', 'payrollPeriodGroup', 'salaryBenefits' => function($q){
            return $q->with(['component']);
        }])->newQuery();
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
            ->addAction(['width' => '120px', 'printable' => false, 'defaultContent' => '','title' => __('crud.action')])
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
        $departmentRepository = new DepartmentRepository();
        $joblevelRepository = new JobLevelRepository();
        $jobtitleRepository = new JobTitleRepository();
        $businessUnitRepository = new BusinessUnitRepository();
        $departmentItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.department_id'), 'value' => '']], convertArrayPairValueWithKey($departmentRepository->pluck()));
        $joblevelItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.joblevel_id'), 'value' => '']], convertArrayPairValueWithKey($joblevelRepository->pluck()));
        $jobtitleItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.jobtitle_id'), 'value' => '']], convertArrayPairValueWithKey($jobtitleRepository->pluck()));
        $businessUnitItem = array_merge([['text' => 'Pilih '.__('models/employees.fields.business_unit_id'), 'value' => '']], convertArrayPairValueWithKey($businessUnitRepository->pluck()));
        
        return [
            'code' => new Column(['title' => __('models/employees.fields.code'),'name' => 'code', 'data' => 'code', 'searchable' => true, 'elmsearch' => 'text']),
            'full_name' => new Column(['title' => __('models/employees.fields.full_name'),'name' => 'full_name', 'data' => 'full_name', 'searchable' => true, 'elmsearch' => 'text']),
            // 'contract_id' => new Column(['title' => __('models/employees.fields.contract_id'),'name' => 'contract_id', 'data' => 'contract_id', 'searchable' => true, 'elmsearch' => 'text']),
            // 'company_id' => new Column(['title' => __('models/employees.fields.company_id'),'name' => 'company_id', 'data' => 'company_id', 'searchable' => true, 'elmsearch' => 'text']),
            'department_id' => new Column(['title' => __('models/employees.fields.department_id'),'name' => 'department_id', 'data' => 'department.name','defaultContent' => '-', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $departmentItem, 'multiple' => 'multiple', 'width' => '200px']),
            'business_unit_id' => new Column(['title' => __('models/employees.fields.business_unit_id'),'name' => 'business_unit_id', 'data' => 'business_unit.name','defaultContent' => '-', 'searchable' => true, 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $businessUnitItem, 'multiple' => 'multiple', 'width' => '200px']),
            'joblevel_id' => new Column(['title' => __('models/employees.fields.joblevel_id'),'name' => 'joblevel_id', 'data' => 'joblevel.name','defaultContent' => '-', 'searchable' => true, 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $joblevelItem, 'multiple' => 'multiple', 'width' => '200px']),
            'jobtitle_id' => new Column(['title' => __('models/employees.fields.jobtitle_id'),'name' => 'jobtitle_id', 'data' => 'jobtitle.name','defaultContent' => '-', 'searchable' => true, 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $jobtitleItem, 'multiple' => 'multiple', 'width' => '200px']),
            // 'supervisor_id' => new Column(['title' => __('models/employees.fields.supervisor_id'),'name' => 'supervisor_id', 'data' => 'supervisor_id', 'searchable' => true, 'elmsearch' => 'text']),
            // 'region_of_birth_id' => new Column(['title' => __('models/employees.fields.region_of_birth_id'),'name' => 'region_of_birth_id', 'data' => 'region_of_birth_id', 'searchable' => true, 'elmsearch' => 'text']),
            // 'city_of_birth_id' => new Column(['title' => __('models/employees.fields.city_of_birth_id'),'name' => 'city_of_birth_id', 'data' => 'city_of_birth_id', 'searchable' => true, 'elmsearch' => 'text']),
            // 'address' => new Column(['title' => __('models/employees.fields.address'),'name' => 'address', 'data' => 'address', 'searchable' => true, 'elmsearch' => 'text']),
            'join_date' => new Column(['title' => __('models/employees.fields.join_date'),'name' => 'join_date', 'data' => 'join_date', 'searchable' => true, 'elmsearch' => 'text']),
            'employee_status' => new Column(['title' => __('models/employees.fields.employee_status'),'name' => 'employee_status', 'data' => 'employee_status', 'searchable' => true, 'elmsearch' => 'text']),            
            // 'gender' => new Column(['title' => __('models/employees.fields.gender'),'name' => 'gender', 'data' => 'gender', 'searchable' => true, 'elmsearch' => 'text']),
            // 'date_of_birth' => new Column(['title' => __('models/employees.fields.date_of_birth'),'name' => 'date_of_birth', 'data' => 'date_of_birth', 'searchable' => true, 'elmsearch' => 'text']),
            // 'identity_number' => new Column(['title' => __('models/employees.fields.identity_number'),'name' => 'identity_number', 'data' => 'identity_number', 'searchable' => true, 'elmsearch' => 'text']),
            // 'identity_type' => new Column(['title' => __('models/employees.fields.identity_type'),'name' => 'identity_type', 'data' => 'identity_type', 'searchable' => true, 'elmsearch' => 'text']),
            // 'marital_status' => new Column(['title' => __('models/employees.fields.marital_status'),'name' => 'marital_status', 'data' => 'marital_status', 'searchable' => true, 'elmsearch' => 'text']),
            // 'email' => new Column(['title' => __('models/employees.fields.email'),'name' => 'email', 'data' => 'email', 'searchable' => true, 'elmsearch' => 'text']),
            // 'leave_balance' => new Column(['title' => __('models/employees.fields.leave_balance'),'name' => 'leave_balance', 'data' => 'leave_balance', 'searchable' => true, 'elmsearch' => 'text']),
            // 'tax_group' => new Column(['title' => __('models/employees.fields.tax_group'),'name' => 'tax_group', 'data' => 'tax_group', 'searchable' => true, 'elmsearch' => 'text']),
            // 'resign_date' => new Column(['title' => __('models/employees.fields.resign_date'),'name' => 'resign_date', 'data' => 'resign_date', 'searchable' => true, 'elmsearch' => 'text']),
            // 'have_overtime_benefit' => new Column(['title' => __('models/employees.fields.have_overtime_benefit'),'name' => 'have_overtime_benefit', 'data' => 'have_overtime_benefit', 'searchable' => true, 'elmsearch' => 'text']),
            // 'risk_ratio' => new Column(['title' => __('models/employees.fields.risk_ratio'),'name' => 'risk_ratio', 'data' => 'risk_ratio', 'searchable' => true, 'elmsearch' => 'text']),
            // 'profile_image' => new Column(['title' => __('models/employees.fields.profile_image'),'name' => 'profile_image', 'data' => 'profile_image', 'searchable' => true, 'elmsearch' => 'text']),
            // 'profile_size' => new Column(['title' => __('models/employees.fields.profile_size'),'name' => 'profile_size', 'data' => 'profile_size', 'searchable' => true, 'elmsearch' => 'text']),
            // 'salary_group_id' => new Column(['title' => __('models/employees.fields.salary_group_id'),'name' => 'salary_group_id', 'data' => 'salary_group_id', 'searchable' => true, 'elmsearch' => 'text']),
            'shiftment_group_id' => new Column(['title' => __('models/employees.fields.shiftment_group_id'),'name' => 'shiftment_group_id', 'data' => 'shiftment_group.name','defaultContent' => '-', 'searchable' => true, 'elmsearch' => 'text'])
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
