<?php

namespace App\Exports\Template\Hr;

use App\Models\Hr\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeeExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping
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
        return [
            'contract_id',
            'company_id',
            'department_id',
            'business_unit',
            'joblevel_id',
            'jobtitle_id',
            'supervisor_id',
            'region_of_birth_id',
            'city_of_birth_id',
            'address',
            'join_date',
            'employee_status',
            'code',
            'full_name',
            'gender',
            'date_of_birth',
            'identity_number',
            'identity_type',
            'marital_status',
            'email',
            'leave_balance',        
            'have_overtime_benefit',
            'overtime',
            'salary',
            'position_allowance',
            'bpjs_kesehatan',
            'bpjs_jht',
            'bpjs_jp',
            'salary_group_id',
            'shiftment_group_id'
        ];
    }
}
