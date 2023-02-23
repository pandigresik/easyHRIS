<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Models\Hr\GroupingPayrollEntity;

class DetailPayrollExport implements WithMultipleSheets
{
    use Exportable;
    /**
     * @var Collection
     */
    protected $collection;
    protected $salaryComponent;
    protected $payrollPeriod;
    public function __construct(Collection $collection, $salaryComponent, $payrollPeriod)
    {
        $this->collection = $collection;
        $this->salaryComponent = $salaryComponent;
        $this->payrollPeriod = $payrollPeriod;
    }
     /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $payrollEntity = GroupingPayrollEntity::pluck('name', 'id');
        $typePayrollPeriod = $this->payrollPeriod->payrollPeriodGroup->type_period ?? 'biweekly';
        foreach ($payrollEntity as $id => $entityName) {
            $data = $this->collection[$id] ?? collect([]);
            if ($data->isEmpty()) {
                continue;
            }
            switch($typePayrollPeriod){
                case 'monthly':
                    $sheets[] = new EmployeePayrollMonthlySheet($data, $this->salaryComponent, $entityName, $this->payrollPeriod);
                    break;
                default:
                    $sheets[] = new EmployeePayrollSheet($data, $this->salaryComponent, $entityName, $this->payrollPeriod);
            }
            
        }
        $sheets[] = new TransferSalarySheet($this->collection, $payrollEntity, 'REKAP DAFTAR TRANSFER', $this->payrollPeriod);
        return $sheets;
    }
}
