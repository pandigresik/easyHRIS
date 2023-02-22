<?php

namespace App\Imports\Hr;

use App\Models\Base\BusinessUnit;
use App\Models\Base\Company;
use App\Models\Base\Department;
use App\Models\Hr\Employee;
use App\Models\Hr\JobLevel;
use App\Models\Hr\JobTitle;
use App\Models\Hr\PayrollPeriodGroup;
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
use PhpOffice\PhpSpreadsheet\Shared\Date;

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
    private $jobTitle;
    private $payrollGroup;
    private $dateColumn = ['join_date', 'date_of_birth', 'resign_date'];
    public function __construct()
    {
        $this->departement = Department::select(['id', 'name'])->get()->keyBy('name');
        $this->jobLevel = JobLevel::select(['id', 'name'])->get()->keyBy('name');  
        $this->jobTitle = JobTitle::select(['id', 'name'])->get()->keyBy('name');  
        $this->salaryGroup = SalaryGroup::select(['id', 'name'])->with('salaryGroupDetails')->get()->keyBy('name');
        $this->shiftmentGroup = ShiftmentGroup::select(['id', 'name'])->get()->keyBy('name');
        $this->salaryComponent = SalaryComponent::whereIn('code',['GP', 'GPH', 'OT', 'JPM', 'JHTM', 'PJKNM', 'TJ','TUMLM', 'UM', 'PRHD', 'PTHD', 'TMHL', 'UML'])->get()->keyBy('code');
        $this->businessUnit = BusinessUnit::select(['id', 'name'])->get()->keyBy('name');
        $this->company = Company::select(['id', 'name'])->get()->keyBy('name');
        $this->payrollGroup = PayrollPeriodGroup::get()->keyBy('name');
    }
    public function collection(Collection $rows)
    {      
      $userId = \Auth::id(); 
      foreach($rows as $row){
        foreach($this->dateColumn as $date){
            if(isset($row[$date])){
                if(is_numeric($row[$date])){
                    $row[$date] = Date::excelToDateTimeObject($row[$date])->format('Y-m-d');
                }
            }
            
        }
        $overtime = $row['overtime'];
        $salary = $row['salary'];
        $positionAllowance = $row['position_allowance'];
        $bpjsFeeJkn = $row['bpjs_kesehatan'];
        $bpjsFeeJht = $row['bpjs_jht'];
        $bpjsFeeJp = $row['bpjs_jp'];
        $premiKehadiran = $row['premi_kehadiran'];
        $uangMakan = $row['uang_makan'];
        $uangMakanLembur = $row['uang_makan_lembur'];
        $tunjanganMasukHariLibur = $row['tunjangan_masuk_hari_libur'];
        $tunjanganMinggu = $row['tunjangan_minggu'];
        unset($row['overtime']);
        unset($row['salary']);
        unset($row['position_allowance']);
        unset($row['bpjs_kesehatan']);
        unset($row['bpjs_jht']);
        unset($row['bpjs_jp']);
        unset($row['tunjangan_minggu']);
        unset($row['premi_kehadiran']);
        unset($row['uang_makan']);
        unset($row['uang_makan_lembur']);
        unset($row['tunjangan_masuk_hari_libur']);
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
        $payrollGroup = $row['payroll_period_group_id'];
        $row['payroll_period_group_id'] = $this->payrollGroup[$payrollGroup]->id ?? NULL;
        $row['created_by'] = $userId;
        // jika bulanan maka, potongan hadir gaji dibagi 25
        $salaryDay = $this->payrollGroup[$payrollGroup]->type_period == 'monthly' ? ($salary / 25) : $salary;
        Employee::upsert($row->toArray(), ['code']);
        (new Employee())->flushCache();  
        $employee = Employee::whereCode($row['code'])->first();
        $salaryDetails = $this->salaryGroup[$salaryGroup]->salaryGroupDetails ?? NULL;
        $this->createSalaryBenefit($employee, $salaryDetails ,[
            $this->salaryComponent['OT']->id => $overtime, 
            $this->salaryComponent['GPH']->id => $salary, 
            $this->salaryComponent['GP']->id => $salary,
            $this->salaryComponent['PTHD']->id => $salaryDay,
            $this->salaryComponent['JPM']->id => $bpjsFeeJp, 
            $this->salaryComponent['JHTM']->id => $bpjsFeeJht,
            $this->salaryComponent['PJKNM']->id => $bpjsFeeJkn,
            $this->salaryComponent['UM']->id => $uangMakan,
            $this->salaryComponent['UML']->id => $uangMakanLembur,
            $this->salaryComponent['TMHL']->id => $tunjanganMasukHariLibur,
            $this->salaryComponent['PRHD']->id => $premiKehadiran,
            $this->salaryComponent['TJ']->id => $positionAllowance,
            $this->salaryComponent['TUMLM']->id => $tunjanganMinggu
        ]);
      }
//      (new SalaryBenefit())->flushCache();      
    }

    private function createSalaryBenefit($employee, $salaryDetails, $dataBenefit){
        $userId = \Auth::id();
        if($salaryDetails){
            foreach($salaryDetails as $detail){                
                $insertBenefit = ['employee_id' => $employee->id, 'component_id' => $detail->component_id];
                $salaryBenefit = SalaryBenefit::firstOrCreate($insertBenefit);
                
                $componentId = $detail->getRawOriginal('component_id');
                
                if(isset($dataBenefit[$componentId])){
                    $benefitValue = $dataBenefit[$componentId];
                    $salaryBenefit->benefit_value = $benefitValue;
                    $salaryBenefit->save();
                }else{
                    // jika belum ada maka buat, jika sudah ada maka biarkan saja
                    // bisa jadi memang diubah manual 
                    $benefitValue = $detail->getRawOriginal('component_value');                     
                    if($salaryBenefit->wasRecentlyCreated){
                        $salaryBenefit->benefit_value = $benefitValue;
                        $salaryBenefit->save();
                    }
                }
                                
                // SalaryBenefit::upsert($insertBenefit, ['employee_id', 'component_id']);
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