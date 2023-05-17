<?php

namespace App\Exports;

use App\Repositories\Hr\JobLevelRepository;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithPreCalculateFormulas;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class EmployeePayrollMonthlySheet implements FromView, WithColumnFormatting, WithTitle, WithEvents, WithPreCalculateFormulas
{
    private $salaryComponent;
    private $sheetName;    
    private $payrollPeriod;
    private $collection;    
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
        if($this->sheetName == 'LJP Non Staff'){
            return view('exports.monthly_non_staff_payrolls', [
                'jobLevel' => (new JobLevelRepository())->pluck(),
                'payrolls' => $this->collection,
                'component' => $this->salaryComponent,
                'periodTitle' => $this->payrollPeriod->range_period,
                'premiMonth' => substr(localFormatFullDate($this->payrollPeriod->getRawOriginal('start_period')), 2),
                'periodMonth' => Carbon::parse($this->payrollPeriod->getRawOriginal('start_period'))->format('F Y')
            ]);    
        }
        return view('exports.monthly_payrolls', [
            'jobLevel' => (new JobLevelRepository())->pluck(),
            'payrolls' => $this->collection,
            'component' => $this->salaryComponent,
            'periodTitle' => $this->payrollPeriod->range_period,
            'premiMonth' => substr(localFormatFullDate($this->payrollPeriod->getRawOriginal('start_period')), 2),
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
        $formatNumberDecimal = "#,##0.00";        
        return [
            'G' => $formatNumber,
            'H' => $formatNumber,
            'I' => $formatNumber,
            'J' => $formatNumber,
            'K' => $formatNumber,
            'L' => $formatNumberDecimal,
            'M' => $formatNumber,
            'N' => $formatNumber,
            'O' => $formatNumber,
            'P' => $formatNumber,
            'Q' => $formatNumber,
            'R' => $formatNumber,
            'S' => $formatNumberDecimal,
            'T' => $formatNumber,
            'U' => $formatNumber,
            'V' => $formatNumber,
            'W' => $formatNumber,
            'X' => $formatNumber,
            'Y' => $formatNumber,
            'Z' => $formatNumber,
            'AA' => $formatNumber                   
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $headerCellRange = 'A4:AA5';                
                $worksheet = $event->sheet->getDelegate();
                $lastRow = $worksheet->getHighestDataRow();
                $tableRange = 'A4:AA'.$lastRow;
                $worksheet->freezePane('A6');
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
