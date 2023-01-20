<?php

namespace App\DataTables\Hr;

use App\Models\Hr\Overtime;
use App\DataTables\BaseDataTable as DataTable;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Column;

class OvertimeApproveDataTable extends DataTable
{
    protected $fastExcel = false;    
    private $createdRequest; 
    /**
    * example mapping filter column to search by keyword, default use %keyword%
    */
    private $columnFilterOperator = [
        'employee.full_name' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'employee.code' => \App\DataTables\FilterClass\RelationContainKeyword::class,
        'overtime_date' => \App\DataTables\FilterClass\BetweenKeyword::class,
        'amount' =>  \App\DataTables\FilterClass\BetweenKeyword::class,
        // 'shiftment_id' => \App\DataTables\FilterClass\InKeyword::class,        
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
        $dataTable->skipPaging();
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
     * @param \App\Models\Overtime $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Overtime $model)
    {
        // get own data user and all employee descendant                
        $employeeId = 0;
        $employee = \Auth::user()->employee;        
        if($employee){
            $employeeId = $employee->id;            
        }
        return $model->selectRaw($model->getTable().'.*')
            ->disableModelCaching()
            ->needApproval($employeeId, $this->getCreatedRequest())
            ->with(['employee'])->newQuery();        
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
                'order'     => [[0, 'desc']],                
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
            'employee.full_name' => new Column(['title' => __('models/overtimes.fields.employee_full_name'),'name' => 'employee.full_name', 'data' => 'employee.full_name', 'searchable' => false, 'elmsearch' => 'text']),
            'employee.code' => new Column(['title' => __('models/overtimes.fields.employee_code'),'name' => 'employee.code', 'data' => 'employee.code', 'searchable' => false, 'elmsearch' => 'text']),     
            'overtime_date' => new Column(['title' => __('models/overtimes.fields.overtime_date'),'name' => 'overtime_date', 'data' => 'overtime_date', 'searchable' => false, 'elmsearch' => 'daterange']),
            'start_hour' => new Column(['title' => __('models/overtimes.fields.start_hour'),'name' => 'start_hour', 'data' => 'start_hour', 'searchable' => false, 'elmsearch' => 'text']),
            'end_hour' => new Column(['title' => __('models/overtimes.fields.end_hour'),'name' => 'end_hour', 'data' => 'end_hour', 'searchable' => false, 'elmsearch' => 'text']),
            'status' => new Column(['title' => __('models/requestWorkshifts.fields.status'),'name' => 'status', 'data' => 'status', 'searchable' => false, 'elmsearch' => 'false']),
            'description' => new Column(['title' => __('models/overtimes.fields.description'),'name' => 'description', 'data' => 'description', 'searchable' => false, 'elmsearch' => 'text'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'overtimes_datatable_' . time();
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
