<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeePayrollSheet implements FromView, WithColumnFormatting, WithTitle, WithEvents, WithPreCalculateFormulas
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $headerCellRange = 'A4:AM7';                
                $worksheet = $event->sheet->getDelegate();
                $lastRow = $worksheet->getHighestDataRow();
                $tableRange = 'A4:AM'.$lastRow;
                $worksheet->freezePane('A8');
                $worksheet->getStyle($headerCellRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);
                $worksheet->getStyle($headerCellRange)->getFont()->setSize(11)->setBold(true);
                $worksheet->getStyle($headerCellRange)->applyFromArray(['alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, 'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER]]);
                $worksheet->getStyle($tableRange)->applyFromArray(['borders' => [
                    'allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    // 'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    // 'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],
                    // 'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]                    
                    ]]);
            }
        ];
    }
}
