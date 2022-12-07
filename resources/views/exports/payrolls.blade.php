<table>
    <tr><td colspan="6">REKAPITULASI GAJI KARYAWAN HARIAN - DWI MINGGUAN</td></tr>
    <tr><td>Periode </td><td colspan="5"> : {{ $periodTitle }}</td></tr>    
</table>

<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="4">No.</th>
            <th rowspan="4">No. Induk</th>
            <th rowspan="4">Nama Tenaga Kerja</th>
            <th rowspan="4">BISNIS UNIT</th>
            <th rowspan="4">DEPARTEMEN</th>
            <th rowspan="4">Jabatan / Divisi</th>
            <th rowspan="4">Status Kontrak</th>
            <th rowspan="4">Gaji / hari</th>
            <th colspan="18">Penerimaan</th>
            <th colspan="12">Potongan</th>            					
            <th rowspan="4">Gaji Netto</th>
        </tr>
        <tr>
            <th rowspan="3">Kehadiran</th>
            <th rowspan="3">Gaji</th>
            <th colspan="3">Overtime</th>
            <th rowspan="2">Tunj dan UM Lembur</th>
            <th rowspan="3">Tunjangan</th>
            <th rowspan="3">Lain2</th>
            <th rowspan="3">Premi Kehadiran</th>
            <th colspan="2" rowspan="2">Insentif KM ( Rp. 250,- / km )</th>
            <th colspan="2" rowspan="2">Insentif Doble Rit (@25.000 / dobel rit )</th>
            <th colspan="4">Luar Kota</th>
            <th rowspan="3">Total Penerimaan</th>
            <th colspan="5">Absen/Ijin/Terlambat</th>
            <th colspan="5">{{ $periodMonth }}</th>
            <th rowspan="3">Lain2</th>
            <th rowspan="3">TOTAL POTONGAN</th>        
        </tr>
        <tr>
            <th rowspan="2">Jam</th>
            <th rowspan="2">@</th>
            <th rowspan="2">Total Rp</th>
            <th rowspan="2">UM (@60.000/hr)</th>
            <th rowspan="2">Hari</th>
            <th rowspan="2">(2x gaji)</th>
            <th rowspan="2">Total Rp</th>
            <th rowspan="2">Jam</th>
            <th rowspan="2">@</th>
            <th rowspan="2">Total Rp</th>            
            <th rowspan="2">Hari</th>
            <th rowspan="2">Total</th>
            <th rowspan="2">BPJS Kesehatan</th>
            <th rowspan="2">BPJS TK - JHT</th>
            <th rowspan="2">Keluarga Tamb. BPJS Kesehatan</th>
            <th rowspan="2">BPJS TK - JP</th>
            <th rowspan="2">Cicilan</th>
        </tr>
        <tr>
            <th>MINGGU</th>
            <th>Total KM</th>
            <th>Total Rp</th>
            <th>Dobel Rit (x)</th>
            <th>Total Rp</th>
        </tr>
    </thead>
    <tbody>
        @php
            $awalBarisData = 8;
            $no = 0;
        @endphp
        @foreach($payrolls as $no =>  $payroll)
        @php
            $additionalInfo = $payroll->additional_info;
            $payrollDetails = $payroll->payrollDetails->keyBy('component_id');
            /* jenis gaji pokok ada 2, bulanan dan harian*/
            $salaryComponent = $payrollDetails[$component['GPH']] ?? [];
            if(!$salaryComponent){
                $salaryComponent = $payrollDetails[$component['GP']] ?? [];
            }
            $overtimeComponent = $payrollDetails[$component['OT']] ?? [];
            $sundayOvertimeComponent = $payrollDetails[$component['TUMLM']] ?? [];
            /* jenis tunjangan jabatan ada 2, ada yang tunjangan jabatan bulanan dan harian, cara hitungnya beda*/
            $positionComponent = $payrollDetails[$component['TJ']] ?? [];
            if(!$positionComponent){
                $positionComponent = $payrollDetails[$component['TJH']] ?? [];
            }
            $otherComponent = $payrollDetails[$component['TJL']] ?? [];
            $premiComponent = $payrollDetails[$component['PRHD']] ?? [];
            $kmComponent = $payrollDetails[$component['TDKM']] ?? [];
            $doubleRitaseComponent = $payrollDetails[$component['TDDRT']] ?? [];
            $doubleSalaryComponent = $payrollDetails[$component['TDGJ']] ?? [];
            $uangMakanLuarKotaComponent = $payrollDetails[$component['TDUM']] ?? [];

            $potonganKehadiranComponent = $payrollDetails[$component['PTHD']] ?? [];
            $potonganBpjsJpComponent = $payrollDetails[$component['JPM']] ?? [];
            $potonganBpjsJhtComponent = $payrollDetails[$component['JHTM']] ?? [];
            $potonganBpjsKesehatanComponent = $payrollDetails[$component['PJKNM']] ?? [];
            $potonganBpjsTambahanComponent = $payrollDetails[$component['PJKMT']] ?? [];
            $potonganLainComponent = $payrollDetails[$component['PTL']] ?? [];            
                        
            $totalPenerimaan = $payroll->payrollDetails->filter(function($item){
                return $item->getRawOriginal('sign_value') > 0;
            })->sum(function($item){return $item->getRawOriginal('benefit_value'); });
            $totalPotongan = $payroll->payrollDetails->filter(function($item){
                return $item->getRawOriginal('sign_value') < 0;
            })->sum(function($item){return $item->getRawOriginal('benefit_value'); });
            
            $dailySalary = $additionalInfo['dailySalary'] ?? 0;
            $workday = $additionalInfo['workday'] ?? 0;
            $overtimeSalary = $additionalInfo['overtimeSalary'] ?? 0;
            $overtime = $additionalInfo['overtime'] ?? 0;
            $doubleRitSalary = $additionalInfo['doubleRitSalary'] ?? 0;
            $kmSalary = $additionalInfo['kmSalary'] ?? 0;
            $lateEarly = $additionalInfo['late_early'] ?? 0;
            $absent = $additionalInfo['absent'] ?? 0;
            $km = 0;
            $doubleRit = 0;
            $doubleSalaryAmount = 0;

            if($doubleRitaseComponent){
                if($doubleRitaseComponent->getRawOriginal('benefit_value') > 0){
                    $doubleRit = $doubleRitaseComponent->getRawOriginal('benefit_value') / $doubleRitSalary;
                }
            }

            if($kmComponent){
                if($kmComponent->getRawOriginal('benefit_value') > 0){
                    $km = $kmComponent->getRawOriginal('benefit_value') / $kmSalary;
                }
            }

            if($doubleSalaryComponent){
                if($doubleSalaryComponent->getRawOriginal('benefit_value') > 0){
                    $doubleSalaryAmount = $doubleSalaryComponent->getRawOriginal('benefit_value') / $dailySalary;
                }
            }
            
        @endphp
        <tr>
            <td>{{ $no + 1 }}</td>
            <td>{{ $payroll->employee->code }}</td>
            <td>{{ $payroll->employee->full_name }}</td>
            <td>{{ $payroll->employee->businessUnit->name ?? '' }}</td>
            <td>{{ $payroll->employee->department->name ?? '' }}</td>
            <td>{{ $payroll->employee->jobtitle->name ?? '' }}</td>
            <td>{{ $payroll->employee->employee_status }}</td>
            <td>{{ $dailySalary }}</td>
            <td>{{ $workday }}</td>
            <td>{{ $salaryComponent->getRawOriginal('benefit_value') ?? 0 }}</td>                        
            <td>{{ minuteToHour($overtime) }}</td>
            <td>{{ $overtimeSalary }}</td>
            <td>{{ $overtimeComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $sundayOvertimeComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $positionComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $otherComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $premiComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $km }}</td>
            <td>{{ $kmComponent ? ($kmComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $doubleRit }}</td>
            <td>{{ $doubleRitaseComponent ? ($doubleRitaseComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $uangMakanLuarKotaComponent ? ($uangMakanLuarKotaComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $doubleSalaryAmount }}</td>
            <td>{{ $doubleSalaryComponent ? ($doubleSalaryComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ ( $doubleSalaryComponent ? ($doubleSalaryComponent->getRawOriginal('benefit_value') ?? 0) : 0 ) + ( $uangMakanLuarKotaComponent ? ($uangMakanLuarKotaComponent->getRawOriginal('benefit_value') ?? 0) : 0 ) }}</td>
            <td>{{ $totalPenerimaan }}</td>
            <td>{{ round(minuteToHour($lateEarly),2) }}</td>
            <td>{{ round($dailySalary/7, 2) }}</td>
            <td>{{ round($dailySalary/7 * minuteToHour($lateEarly),2) }}</td>
            <td>{{ $absent }}</td>            
            <td>{{ $potonganKehadiranComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $potonganBpjsKesehatanComponent ? ($potonganBpjsKesehatanComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $potonganBpjsJhtComponent ? ($potonganBpjsJhtComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $potonganBpjsTambahanComponent ? ($potonganBpjsTambahanComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $potonganBpjsJpComponent ? ($potonganBpjsJpComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>            
            <td>0</td>
            <td>{{ $potonganLainComponent ? ($potonganLainComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>            
            <td>{{ $totalPotongan }}</td>
            <td>{{ $totalPenerimaan - $totalPotongan }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="10"></td>
            <td>=sum(K{{ $awalBarisData }}:K{{ $no + $awalBarisData }})</td>
            <td></td>
            <td>=sum(M{{ $awalBarisData }}:M{{ $no + $awalBarisData }})</td>
            <td>=sum(N{{ $awalBarisData }}:N{{ $no + $awalBarisData }})</td>
            <td>=sum(O{{ $awalBarisData }}:O{{ $no + $awalBarisData }})</td>
            <td>=sum(P{{ $awalBarisData }}:P{{ $no + $awalBarisData }})</td>
            <td>=sum(Q{{ $awalBarisData }}:Q{{ $no + $awalBarisData }})</td>
            <td>=sum(R{{ $awalBarisData }}:R{{ $no + $awalBarisData }})</td>
            <td>=sum(S{{ $awalBarisData }}:S{{ $no + $awalBarisData }})</td>
            <td>=sum(T{{ $awalBarisData }}:T{{ $no + $awalBarisData }})</td>
            <td>=sum(U{{ $awalBarisData }}:U{{ $no + $awalBarisData }})</td>
            <td>=sum(V{{ $awalBarisData }}:V{{ $no + $awalBarisData }})</td>
            <td>=sum(W{{ $awalBarisData }}:W{{ $no + $awalBarisData }})</td>
            <td>=sum(X{{ $awalBarisData }}:X{{ $no + $awalBarisData }})</td>
            <td>=sum(Y{{ $awalBarisData }}:Y{{ $no + $awalBarisData }})</td>
            <td>=sum(Z{{ $awalBarisData }}:Z{{ $no + $awalBarisData }})</td>
            <td>=sum(AA{{ $awalBarisData }}:AA{{ $no + $awalBarisData }})</td>
            <td></td>            
            <td>=sum(AC{{ $awalBarisData }}:AC{{ $no + $awalBarisData }})</td>
            <td>=sum(AD{{ $awalBarisData }}:AD{{ $no + $awalBarisData }})</td>
            <td>=sum(AE{{ $awalBarisData }}:AE{{ $no + $awalBarisData }})</td>
            <td>=sum(AF{{ $awalBarisData }}:AF{{ $no + $awalBarisData }})</td>
            <td>=sum(AG{{ $awalBarisData }}:AG{{ $no + $awalBarisData }})</td>
            <td>=sum(AH{{ $awalBarisData }}:AH{{ $no + $awalBarisData }})</td>
            <td>=sum(AI{{ $awalBarisData }}:AI{{ $no + $awalBarisData }})</td>
            <td>=sum(AJ{{ $awalBarisData }}:AJ{{ $no + $awalBarisData }})</td>
            <td>=sum(AK{{ $awalBarisData }}:AK{{ $no + $awalBarisData }})</td>
            <td>=sum(AL{{ $awalBarisData }}:AL{{ $no + $awalBarisData }})</td>
            <td>=sum(AM{{ $awalBarisData }}:AM{{ $no + $awalBarisData }})</td>            
        </tr>
    </tbody>
</table>
