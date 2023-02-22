<?php

namespace App\Exports\Template\Hr;

use App\Models\Hr\Employee;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use stdClass;

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
            return Employee::whereNotNUll(['jobtitle_id', 'department_id', 'business_unit_id', 'joblevel_id'])->with(['joblevel', 'jobtitle', 'company', 'department','regionOfBirth', 'businessUnit', 'shiftmentGroup', 'salaryGroup', 'payrollPeriodGroup', 'salaryBenefits' => function($q){
                return $q->with(['component']);
            }])->limit(1)->get();
        }

        return Employee::with(['joblevel', 'jobtitle', 'company', 'department','regionOfBirth', 'businessUnit', 'shiftmentGroup', 'salaryGroup', 'salaryBenefits'  => function($q){
            return $q->with(['component']);
        }])->all();
    }

    /**
     * @var Invoice
     *
     * @param mixed $item
     */
    public function map($item): array
    {
        $result = [];
        $mapRelation = [
            'company_id' => 'company',
            'department_id' => 'department',
            'business_unit_id' => 'businessUnit',
            'joblevel_id' => 'joblevel',
            'jobtitle_id' => 'jobtitle',            
            'region_of_birth_id' => 'regionOfBirth',
            'city_of_birth_id' => 'cityOfBirth',
            'salary_group_id' => 'salaryGroup',
            'shiftment_group_id' => 'shiftmentGroup',
            'payroll_period_group_id' => 'payrollPeriodGroup'
        ];        
        $mapRelationBenefit = [
            'overtime' => 'OT',
            'salary' => ['GPH', 'GP'],
            'premi_kehadiran' => 'PRHD',
            'uang_makan' => 'UM',
            'uang_makan_lembur' => 'UML',
            'tunjangan_masuk_hari_libur' => 'TMHL',
            'position_allowance' => 'TJ',
            'bpjs_kesehatan' => 'PJKNM',
            'bpjs_jht' => 'JHTM',
            'bpjs_jp' => 'JPM',
            'tunjangan_minggu' => 'TUMLM'
        ];  
        $attribute = $this->headings();
        foreach ($attribute as $name) {
            $defaultValue = $item->getRawOriginal($name);
            if(isset($mapRelation[$name])){
                $mapRelationName = $mapRelation[$name];                
                $itemRelation = $item->{$mapRelationName} ?? [];
                if(!empty($itemRelation)){
                    $defaultValue = $itemRelation->name;
                }                
            }

            if(isset($mapRelationBenefit[$name])){
                $benefitMap = $mapRelationBenefit[$name];
                if(is_array($benefitMap)){
                    $salaryBenefits = $item->salaryBenefits->whereIn('component.code', $benefitMap)->first();
                }else{
                    $salaryBenefits = $item->salaryBenefits->where('component.code', $benefitMap)->first();
                }
                $defaultValue = $salaryBenefits ? $salaryBenefits->getRawOriginal('benefit_value') : 0;
            }

            array_push($result, $defaultValue);
        }

        return $result;
    }

    public function headings(): array
    {
        return [            
            'company_id',            
            'code',
            'full_name',
            'business_unit_id',
            'department_id',            
            'jobtitle_id',
            'employee_status',            
            'salary',
            'overtime',            
            'position_allowance',
            'bpjs_kesehatan',
            'bpjs_jht',
            'bpjs_jp',
            'premi_kehadiran',
            'uang_makan',
            'uang_makan_lembur',
            'tunjangan_masuk_hari_libur',
            'tunjangan_minggu',
            'joblevel_id',
            'supervisor_id',
            'have_overtime_benefit',
            'contract_id',
            'region_of_birth_id',
            'city_of_birth_id',
            'address',
            'join_date',                        
            'gender',
            'date_of_birth',
            'identity_number',
            'identity_type',
            'account_bank',
            'marital_status',
            'email',
            'leave_balance',                                
            'salary_group_id',
            'shiftment_group_id',
            'payroll_period_group_id'
        ];
    }
}
