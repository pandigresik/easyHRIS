<?php

namespace App\DataTables\Hr;

use App\Models\Hr\AttendanceLogfinger;
use App\DataTables\BaseDataTable as DataTable;
use App\Repositories\Hr\FingerprintDeviceRepository;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class AttendanceLogfingerDataTable extends DataTable
{
    protected $fastExcel = false;
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'fingertime' => \App\DataTables\FilterClass\BetweenDatetimeKeyword::class,
        'employee.code' => \App\DataTables\FilterClass\RelationMatchKeyword::class,
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
        return $dataTable->addColumn('action', 'hr.attendance_logfingers.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\AttendanceLogfinger $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(AttendanceLogfinger $model)
    {
        return $model->employeeDescendants()->selectRaw($model->getTable().'.*')->with(['employee','fingerprintDevice'])->newQuery();
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
                        'text' => '<i class="fa fa-download"></i> ' .__('auth.app.download').'',
                        'action' => <<<FUNC
                            function(e, dt, button, config){
                                button.data('url', 'hr/downloadLogFingers/download')
                                button.data('target', '_parent')
                                button.data('tipe', 'get')
                                main.redirectUrl(button)
                            }
FUNC
                    ],
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
        $fingerprintDeviceRepository = new FingerprintDeviceRepository();
        $fingerprintDeviceItems = convertArrayPairValueWithKey($fingerprintDeviceRepository->pluck());
        return [
            'fingertime' => new Column(['title' => __('models/attendanceLogfingers.fields.fingertime'),'name' => 'fingertime', 'data' => 'fingertime', 'searchable' => true, 'elmsearch' => 'daterange']),
            'employee.full_name' => new Column(['title' => __('models/attendanceLogfingers.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => true, 'elmsearch' => 'text']),
            'employee.code' => new Column(['title' => __('models/attendanceLogfingers.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => true, 'elmsearch' => 'text']),
            // 'type_absen' => new Column(['title' => __('models/attendanceLogfingers.fields.type_absen'),'name' => 'type_absen', 'data' => 'type_absen', 'searchable' => true, 'elmsearch' => 'text']),
            
            'fingerprint_device_id' => new Column(['title' => __('models/attendanceLogfingers.fields.fingerprint_device_id'),'name' => 'fingerprint_device_id', 'data' => 'fingerprint_device.display_name', 'searchable' => true, 'elmsearch' => 'dropdown', 'listItem' => $fingerprintDeviceItems, 'multiple' => 'multiple'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'attendance_logfingers_datatable_' . time();
    }
}
