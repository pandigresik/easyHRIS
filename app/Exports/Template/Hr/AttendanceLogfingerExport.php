<?php

namespace App\Exports\Template\Hr;

use App\Models\Hr\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AttendanceLogfingerExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
            return Employee::limit(1)->get();
        }

        return Employee::all();
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
        foreach ($attribute as $name) {
            array_push($result, $item->{$name});
        }

        return $result;
    }

    public function headings(): array
    {
        // return (new Employee())->getFillable();
        return [
            'Departemen','Nama','No.ID','Tgl/Waktu','Lokasi ID','No.PIN','Kode Verifikasi','No.Kartu'
        ];
    }
}
