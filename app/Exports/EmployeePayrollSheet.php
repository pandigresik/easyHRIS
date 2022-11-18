<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithTitle;

class EmployeePayrollSheet implements FromView, WithColumnFormatting, WithTitle
{
    private $salaryComponent;
    private $sheetName;    
    private $payrollPeriod;
    public function __construct(Collection $collection, $salaryComponent, $sheetName, $payrollPeriod)
    {
        $this->collection = $collection;
        $this->salaryComponent = $salaryComponent;
        $this->sheetName = $sheetName;
        $this->payrollPeriod = $payrollPeriod;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.payrolls', [
            'payrolls' => $this->collection,
            'component' => $this->salaryComponent,
            'periodTitle' => $this->payrollPeriod->range_period,
            'periodMonth' => Carbon::parse($this->payrollPeriod->getRawOriginal('start_period'))->format('F Y')
        ]);
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->sheetName;
    }

    public function columnFormats(): array
    {   
        $formatNumber = "#,##0";
        return [
            'H' => $formatNumber,
            'I' => $formatNumber,
            'J' => $formatNumber,
            'K' => $formatNumber,
            'L' => $formatNumber,
            'M' => $formatNumber,
            'N' => $formatNumber,
            'O' => $formatNumber,
            'P' => $formatNumber,
            'Q' => $formatNumber,
            'R' => $formatNumber,
            'S' => $formatNumber,
            'T' => $formatNumber,
            'U' => $formatNumber,
            'V' => $formatNumber,
            'W' => $formatNumber,
            'X' => $formatNumber,
            'Y' => $formatNumber,
            'Z' => $formatNumber,
            'AA' => $formatNumber,
            'AB' => $formatNumber,
            'AC' => $formatNumber,
            'AD' => $formatNumber,
            'AE' => $formatNumber,
            'AF' => $formatNumber,
            'AG' => $formatNumber,
            'AH' => $formatNumber,
            'AI' => $formatNumber,
            'AJ' => $formatNumber,
            'AK' => $formatNumber,
            'AL' => $formatNumber,
            'AM' => $formatNumber            
        ];
    }
}
