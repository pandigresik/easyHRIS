<?php

namespace App\Imports\Hr;

use App\Models\Base\Department;
use App\Models\Hr\Employee;
use App\Models\Hr\JobLevel;
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
    public function __construct()
    {
        $this->departement = Department::get()->keyBy('name');
        $this->jobLevel = JobLevel::get()->keyBy('name');  
        $this->salaryGroup = SalaryGroup::with('salaryGroupDetails')->get()->keyBy('name');
        $this->shiftmentGroup = ShiftmentGroup::get()->keyBy('name');
        $this->salaryComponent = SalaryComponent::whereIn('code',['GP', 'OT'])->get()->keyBy('code');
    }
    public function collection(Collection $rows)
    {      
    //   SalaryBenefit::whereNull('deleted_at')->forceDelete();
    //   Employee::whereNull('deleted_at')->forceDelete();
      foreach($rows as $row){
        $overtime = $row['overtime'];
        $salary = $row['salary'];
        unset($row['overtime']);
        unset($row['salary']);
        $department = $row['department_id'];
        $row['department_id'] = $this->departement[$department]->id ?? NULL;
        $jobLevel = $row['joblevel_id'];
        $row['joblevel_id'] = $this->jobLevel[$jobLevel]->id ?? NULL;        
        $salaryGroup = $row['salary_group_id'];
        $row['salary_group_id'] = $this->salaryGroup[$salaryGroup]->id ?? NULL;
        $shiftmentGroup = $row['shiftment_group_id'];
        $row['shiftment_group_id'] = $this->shiftmentGroup[$shiftmentGroup]->id ?? NULL;
        $employee = Employee::updateOrCreate($row->toArray());
        $salaryDetails = $this->salaryGroup[$salaryGroup]->salaryGroupDetails ?? NULL;
        $this->createSalaryBenefit($employee, $salaryDetails ,[$this->salaryComponent['OT']->id => $overtime, $this->salaryComponent['GP']->id => $salary]);
      }
    }

    private function createSalaryBenefit($employee, $salaryDetails, $dataBenefit){               
        if($salaryDetails){
            foreach($salaryDetails as $detail){
                $benefitValue = $detail->getRawOriginal('component_value');    
                $componentId = $detail->getRawOriginal('component_id');
                
                if(isset($dataBenefit[$componentId])){                   
                    $benefitValue = $dataBenefit[$componentId];                    
                }
                $insertBenefit = ['employee_id' => $employee->id, 'component_id' => $detail->component_id, 'benefit_value' => $benefitValue];
                
                SalaryBenefit::updateOrCreate($insertBenefit);
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