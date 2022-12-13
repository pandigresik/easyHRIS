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
use App\Models\Hr\Shiftment;
use App\Models\Hr\ShiftmentGroup;
use App\Models\Hr\Workshift;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WorkshiftImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    private $employee;
    private $shiftment;
    
    public function __construct()
    {
        $this->employee = Employee::get()->keyBy('code');
        $this->shiftment = Shiftment::get()->keyBy('name');        
    }
    public function collection(Collection $rows)
    {      
       //SalaryBenefit::whereNull('deleted_at')->forceDelete();
       //Employee::whereNull('deleted_at')->forceDelete();
       
        foreach ($rows as $row) {
            $workshift = [
                'employee_id' => $this->employee[$row['code']],
                'shiftment_id' => $this->shiftment[$row['shift']],                
                'work_date' => createLocalFormatDate($row['tanggal']),
                'start_hour' => createLocalFormatDateTime($row['jam_awal']),
                'end_hour'=> createLocalFormatDateTime($row['jam_akhir'])
            ];
            Workshift::updateOrCreate($workshift);
        }   
    }

    private function transformTimeFormat($value){
        return str_replace('.',':', $value);
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