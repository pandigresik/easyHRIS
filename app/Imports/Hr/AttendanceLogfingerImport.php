<?php

namespace App\Imports\Hr;

use App\Models\Hr\AttendanceLogfinger;
use App\Models\Hr\Employee;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AttendanceLogfingerImport implements ToCollection, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use Importable;
    private $mapColumn = [
         'employee_id' => 'noid',
         'fingertime' => 'tglwaktu',
         'fingerprint_device_id' => 'lokasi_id'
    ];
    private $mapEmployee;
    function __construct()
    {
        $this->mapEmployee = Employee::select(['code','id'])->get()->pluck('id','code')->toArray();
    }
    public function collection(Collection $rows)    
    {
        foreach ($rows as $row) {
            if(isset($this->mapEmployee[$row[$this->mapColumn['employee_id']]])){
                $raw = [
                    'employee_id' => $this->mapEmployee[$row[$this->mapColumn['employee_id']]],
                    // 'fingertime' => $this->createObjDate($row[$this->mapColumn['fingertime']]),
                    'fingertime' => Carbon::parse($row[$this->mapColumn['fingertime']]),
                    'fingerprint_device_id' => $row[$this->mapColumn['fingerprint_device_id']] ?? NULL,
                ];
                AttendanceLogfinger::upsert($raw, ['employee_id', 'fingertime']);
            }
        }                
    }

    // private function createObjDate($value){
    //     return createLocalFormatDateTime($this->transformTimeFormat($value));
    // }

    // private function transformTimeFormat($value){
    //     return str_replace('.',':', $value);
    // }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }
}