<?php

namespace App\DataTables\Hr;

use App\Models\Hr\RequestWorkshift;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class RequestWorkshiftApproveDataTable extends DataTable
{
    protected $skipPaging = true; 
    private $createdRequest;   
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
        $dataTable->editColumn('id', function($item){
            return '<input type="checkbox" name="reference[]" value="'.$item->id.'" />';
        })->escapeColumns([]);
        return $dataTable;
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\RequestWorkshift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(RequestWorkshift $model)
    {
        $employeeId = 0;
        $employee = \Auth::user()->employee;        
        if($employee){
            $employeeId = $employee->id;            
        }
        return $model->select([$model->getTable().'.*'])
            ->with(['employee', 'shiftment'])
            ->needApproval($employeeId, $this->getCreatedRequest())
            ->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {        
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            // ->addAction(['width' => '120px', 'printable' => false, 'title' => __('crud.action')])
            ->parameters([
                'dom'       => '<"row">rt',
                'stateSave' => true,
                'order'     => [[2, 'asc']],
                // 'buttons'   => $buttons,
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
            'id' => new Column(['title' => '<input type="checkbox" onclick="main.checkAll(this, \'table\')" />','name' => 'id', 'data' => 'id','searchable' => false, 'elmsearch' => 'text', 'orderable' => false]),
            'employee_id' => new Column(['title' => __('models/attendances.fields.employee_id'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => false, 'elmsearch' => 'text']),
            'employee_code' => new Column(['title' => __('models/attendances.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => false, 'elmsearch' => 'text']),
            'shiftment_id' => new Column(['title' => __('models/requestWorkshifts.fields.shiftment_id'),'name' => 'shiftment_id', 'data' => 'shiftment.name', 'searchable' => false, 'elmsearch' => 'text']),
            // 'shiftment_id_origin' => new Column(['title' => __('models/requestWorkshifts.fields.shiftment_id_origin'),'name' => 'shiftment_id_origin', 'data' => 'shiftment_id_origin', 'searchable' => false, 'elmsearch' => 'text']),
            'work_date' => new Column(['title' => __('models/requestWorkshifts.fields.work_date'),'name' => 'work_date', 'data' => 'work_date', 'searchable' => false, 'elmsearch' => 'text']),
            'start_hour' => new Column(['title' => __('models/workshifts.fields.start_hour'),'name' => 'start_hour', 'data' => 'start_hour', 'searchable' => false]),
            'end_hour' => new Column(['title' => __('models/workshifts.fields.end_hour'),'name' => 'end_hour', 'data' => 'end_hour', 'searchable' => false]),
            'status' => new Column(['title' => __('models/requestWorkshifts.fields.status'),'name' => 'status', 'data' => 'status', 'searchable' => false, 'elmsearch' => 'false']),
            'description' => new Column(['title' => __('models/requestWorkshifts.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => false, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'request_workshifts_datatable_' . time();
    }

    /**
     * Get the value of createdRequest
     */ 
    public function getCreatedRequest()
    {
        return $this->createdRequest;
    }

    /**
     * Set the value of createdRequest
     *
     * @return  self
     */ 
    public function setCreatedRequest($createdRequest)
    {
        $this->createdRequest = $createdRequest;

        return $this;
    }
}
