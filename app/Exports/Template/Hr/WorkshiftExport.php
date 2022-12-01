<?php

namespace App\Exports\Template\Hr;

use App\Models\Hr\Workshift;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class WorkshiftExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
{
    use Exportable;
    private $isTemplate = false;

    public function __construct(bool $isTemplate = false)
    {
        $this->isTemplate = $isTemplate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        if ($this->isTemplate) {
            return Workshift::with(['employee', 'shiftment'])->limit(1)->get();
        }

        return Workshift::all();
    }

    /**
     * @var Invoice
     *
     * @param mixed $item
     */
    public function map($item): array
    {
        $result = [];
        $attribute = $this->headings();
        $mapHeading = ['code' => 'employee->code','shift' => 'shiftment->name', 'tanggal' => 'work_date','jam_awal' => 'start_hour','jam_akhir' => 'end_hour'];
        foreach ($attribute as $name) {
            $value = $item->{$mapHeading[$name]};
            if($name == 'code'){
                $value = $item->employee->code;
            }
            if($name == 'shift'){
                $value = $item->shiftment->name;
            }
            array_push($result, $value);
        }

        return $result;
    }

    public function headings(): array
    {        
        return [
            'code','shift', 'tanggal','jam_awal','jam_akhir'
        ];
    }
}
