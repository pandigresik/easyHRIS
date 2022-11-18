<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;

class TransferSalarySheet implements FromView, WithColumnFormatting, WithTitle, WithEvents
{
    private $payrollEntity;
    private $sheetName;    
    private $payrollPeriod;
    public function __construct(Collection $collection, $payrollEntity, $sheetName, $payrollPeriod)
    {
        $this->collection = $collection;
        $this->payrollEntity = $payrollEntity;
        $this->sheetName = $sheetName;
        $this->payrollPeriod = $payrollPeriod;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        return view('exports.transfers', [
            'payrollEntity' => $this->payrollEntity,
            'collection' => $this->collection,     
            'periodTitle' => $this->payrollPeriod->range_period            
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
            'F' => $formatNumber,
            'G' => $formatNumber,
            'H' => $formatNumber,
            'I' => $formatNumber,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event){
                $headerCellRange = 'A4:J4';
                $worksheet = $event->sheet->getDelegate();
                $worksheet->freezePane('A5');
                $worksheet->getStyle($headerCellRange)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);
                $worksheet->getStyle($headerCellRange)->getFont()->setSize(12);
            }
        ];
    }
}
