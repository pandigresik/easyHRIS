<?php

namespace App\Imports\Hr;

use App\Models\Base\BusinessUnit;
use App\Models\Base\Company;
use App\Models\Base\Department;
use App\Models\Hr\Employee;
use App\Models\Hr\JobLevel;
use App\Models\Hr\JobTitle;
use App\Models\Hr\SalaryBenefit;
use App\Models\Hr\SalaryComponent;
use App\Models\Hr\SalaryGroup;
use App\Models\Hr\ShiftmentGroup;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    private $departement;
    private $jobLevel;
    private $salaryGroup;
    private $shiftmentGroup;
    private $salaryComponent;
    private $businessUnit;
    private $company;
    private $joTitle;
    public function __construct()
    {
        $this->departement = Department::get()->keyBy('name');
        $this->jobLevel = JobLevel::get()->keyBy('name');  
        $this->jobTitle = JobTitle::get()->keyBy('name');  
        $this->salaryGroup = SalaryGroup::with('salaryGroupDetails')->get()->keyBy('name');
        $this->shiftmentGroup = ShiftmentGroup::get()->keyBy('name');
        $this->salaryComponent = SalaryComponent::whereIn('code',['GP', 'GPH', 'OT', 'JPM', 'JHTM', 'PJKNM', 'TJ'])->get()->keyBy('code');
        $this->businessUnit = BusinessUnit::get()->keyBy('name');
        $this->company = Company::get()->keyBy('name');
    }
    public function collection(Collection $rows)
    {      
       //SalaryBenefit::whereNull('deleted_at')->forceDelete();
       //Employee::whereNull('deleted_at')->forceDelete();
       
      foreach($rows as $row){
        $overtime = $row['overtime'];
        $salary = $row['salary'];
        $positionAllowance = $row['position_allowance'];
        $bpjsFeeJkn = $row['bpjs_kesehatan'];
        $bpjsFeeJht = $row['bpjs_jht'];
        $bpjsFeeJp = $row['bpjs_jp'];
        unset($row['overtime']);
        unset($row['salary']);
        unset($row['position_allowance']);
        unset($row['bpjs_kesehatan']);
        unset($row['bpjs_jht']);
        unset($row['bpjs_jp']);
        $company = $row['company_id'];
        $row['company_id'] = $this->company[$company]->id ?? NULL;
        $businessUnit = $row['business_unit_id'];
        $row['business_unit_id'] = $this->businessUnit[$businessUnit]->id ?? NULL;
        $department = $row['department_id'];
        $row['department_id'] = $this->departement[$department]->id ?? NULL;
        $jobLevel = $row['joblevel_id'];
        $row['joblevel_id'] = $this->jobLevel[$jobLevel]->id ?? NULL;
        $jobTitle = $row['jobtitle_id'];
        $row['jobtitle_id'] = $this->jobTitle[$jobTitle]->id ?? NULL;
        $salaryGroup = $row['salary_group_id'];
        $row['salary_group_id'] = $this->salaryGroup[$salaryGroup]->id ?? NULL;
        $shiftmentGroup = $row['shiftment_group_id'];
        $row['shiftment_group_id'] = $this->shiftmentGroup[$shiftmentGroup]->id ?? NULL;
        $employee = Employee::updateOrCreate($row->toArray());
        $salaryDetails = $this->salaryGroup[$salaryGroup]->salaryGroupDetails ?? NULL;
        $this->createSalaryBenefit($employee, $salaryDetails ,[
            $this->salaryComponent['OT']->id => $overtime, 
            $this->salaryComponent['GPH']->id => $salary, 
            $this->salaryComponent['GP']->id => $salary,
            $this->salaryComponent['JPM']->id => $bpjsFeeJp, 
            $this->salaryComponent['JHTM']->id => $bpjsFeeJht,
            $this->salaryComponent['PJKNM']->id => $bpjsFeeJkn,
            $this->salaryComponent['TJ']->id => $positionAllowance            
        ]);
      }
      (new SalaryBenefit())->flushCache();
    }

    private function createSalaryBenefit($employee, $salaryDetails, $dataBenefit){
        $userId = \Auth::id();
        if($salaryDetails){
            foreach($salaryDetails as $detail){
                $benefitValue = $detail->getRawOriginal('component_value');    
                $componentId = $detail->getRawOriginal('component_id');
                
                if(isset($dataBenefit[$componentId])){                   
                    $benefitValue = $dataBenefit[$componentId];            
                }
                $insertBenefit = ['employee_id' => $employee->id, 'component_id' => $detail->component_id, 'benefit_value' => $benefitValue, 'created_by' => $userId];                
                SalaryBenefit::upsert($insertBenefit, ['employee_id', 'component_id']);
            }
        }
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}