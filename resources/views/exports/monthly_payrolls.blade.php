<table>
    <tr><td colspan="6">REKAPITULASI GAJI KARYAWAN BULANAN - PAYROLL</td></tr>
    <tr><td>Periode </td><td colspan="5"> : {{ $periodTitle }}</td></tr>    
</table>

<table class="table table-bordered">
    <thead>
        <tr>
            <th rowspan="2">No.</th>
            <th rowspan="2">No. Induk</th>
            <th rowspan="2">Nama Tenaga Kerja</th>
            <th rowspan="2">BISNIS UNIT</th>
            <th rowspan="2">DEPARTEMEN</th>
            <th rowspan="2">Jabatan / Divisi</th>            
            <td colspan=9>PENERIMAAN</td>
            <td colspan=8>POTONGAN</td>            
            <td rowspan="2">NETTO</td>
        </tr>
        <tr>
            <td>GAPOK</td>
            <td>TJ JABATAN</td>
            <td>LAIN2-1</td>
            <td>PREMI HADIR DESEMBER 2022</td>
            <td>UPAH LEMBUR / JAM</td>
            <td>TOTAL LEMBUR</td>
            <td>UM</td>
            <td>UML</td>
            <td>TOTAL PENERIMAAN</td>
            <td>Hari</td>
            <td>Jam</td>
            <td>BPJS TK/JHT</td>
            <td>BPJS TK/JP</td>
            <td>BPJS KES</td>
            <td>BPJS KES+</td>
            <td>LAIN2</td>
            <td>TOTAL POTONGAN</td>            
        </tr>        
    </thead>
    <tbody>
        @php
            $awalBarisData = 6;
            $no = 0;            
            $barisKosong = 0;
            $awalBarisKosong = 2;
        @endphp
        @foreach($payrolls->groupBy('employee.joblevel_id') as $keyLevel =>  $payrollLevels)
            <tr>
                <td colspan="24">Level Jabatan {{ $jobLevel[$keyLevel] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="24"></td>
            </tr>
            @php
                $barisKosong += 2;
            @endphp
            @foreach($payrollLevels as $payroll)
            @php
                $additionalInfo = $payroll->additional_info;
                $payrollDetails = $payroll->payrollDetails->keyBy('component_id');            
                $salaryComponent = $payrollDetails[$component['GP']] ?? [];            
                $overtimeComponent = $payrollDetails[$component['OT']] ?? [];
                // $sundayOvertimeComponent = $payrollDetails[$component['TUMLM']] ?? [];
                /* jenis tunjangan jabatan ada 2, ada yang tunjangan jabatan bulanan dan harian, cara hitungnya beda*/
                $positionComponent = $payrollDetails[$component['TJ']] ?? [];
                if(!$positionComponent){
                    $positionComponent = $payrollDetails[$component['TJH']] ?? [];
                }
                $otherComponent = $payrollDetails[$component['TJL']] ?? [];
                $premiComponent = $payrollDetails[$component['PRHD']] ?? [];
                $uangMakanComponent = $payrollDetails[$component['UM']] ?? [];
                $uangMakanLemburComponent = $payrollDetails[$component['UML']] ?? [];
                $tunjanganMasukHariLiburComponent = $payrollDetails[$component['TMHL']] ?? [];

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
                $lateEarly = $additionalInfo['late_early'] ?? 0;
                $absent = $additionalInfo['absent'] ?? 0;
                $km = 0;
                $doubleRit = 0;
                $doubleSalaryAmount = 0;

                $summaryOtherComponent = 0;
                if($tunjanganMasukHariLiburComponent){
                    $summaryOtherComponent += $tunjanganMasukHariLiburComponent->getRawOriginal('benefit_value') ?? 0;
                }
                if($otherComponent){
                    $summaryOtherComponent += $otherComponent->getRawOriginal('benefit_value') ?? 0;
                }
                                
            @endphp
            <tr>
                <td>{{ ( ++$no ) }}</td>
                <td>{{ $payroll->employee->code }}</td>
                <td>{{ $payroll->employee->full_name }}</td>
                <td>{{ $payroll->employee->businessUnit->name ?? '' }}</td>
                <td>{{ $payroll->employee->department->name ?? '' }}</td>
                <td>{{ $payroll->employee->jobtitle->name ?? '' }}</td>                                   
                <td>{{ $salaryComponent->getRawOriginal('benefit_value') ?? 0 }}</td>                        
                <td>{{ $positionComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
                <td>{{ $summaryOtherComponent }}</td>
                <td>{{ $premiComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
                <td>{{ $overtimeSalary }}</td>            
                <td>{{ $overtimeComponent->getRawOriginal('benefit_value') ?? 0 }}</td>            
                <td>{{ $uangMakanComponent ? ($uangMakanComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
                <td>{{ $uangMakanLemburComponent ? ($uangMakanLemburComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>            
                <td>{{ $totalPenerimaan }}</td>            
                <td>{{ $absent * $dailySalary }}</td>  
                <td>{{ round($dailySalary/7 * minuteToHour($lateEarly),2) }}</td>          
                <td>{{ $potonganBpjsJhtComponent ? ($potonganBpjsJhtComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
                <td>{{ $potonganBpjsJpComponent ? ($potonganBpjsJpComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>  
                <td>{{ $potonganBpjsKesehatanComponent ? ($potonganBpjsKesehatanComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>                
                <td>{{ $potonganBpjsTambahanComponent ? ($potonganBpjsTambahanComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>                                          
                <td>{{ $potonganLainComponent ? ($potonganLainComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>            
                <td>{{ $totalPotongan }}</td>
                <td>{{ $totalPenerimaan - $totalPotongan }}</td>
            </tr>
            @endforeach        
        @endforeach
        <tr>
            <td colspan="24"></td>
        </tr>
        <tr>
            <td colspan="6"></td>
            <td>=sum(G{{ $awalBarisData + $awalBarisKosong }}:G{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(H{{ $awalBarisData + $awalBarisKosong }}:H{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(I{{ $awalBarisData + $awalBarisKosong }}:I{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(J{{ $awalBarisData + $awalBarisKosong }}:J{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(K{{ $awalBarisData + $awalBarisKosong }}:K{{ $no + $barisKosong + $awalBarisData }})</td>            
            <td>=sum(L{{ $awalBarisData + $awalBarisKosong }}:L{{ $no + $barisKosong + $awalBarisData }})</td>            
            <td>=sum(M{{ $awalBarisData + $awalBarisKosong }}:M{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(N{{ $awalBarisData + $awalBarisKosong }}:N{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(O{{ $awalBarisData + $awalBarisKosong }}:O{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(P{{ $awalBarisData + $awalBarisKosong }}:P{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(Q{{ $awalBarisData + $awalBarisKosong }}:Q{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(R{{ $awalBarisData + $awalBarisKosong }}:R{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(S{{ $awalBarisData + $awalBarisKosong }}:S{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(T{{ $awalBarisData + $awalBarisKosong }}:T{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(U{{ $awalBarisData + $awalBarisKosong }}:U{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(V{{ $awalBarisData + $awalBarisKosong }}:V{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(W{{ $awalBarisData + $awalBarisKosong }}:W{{ $no + $barisKosong + $awalBarisData }})</td>
            <td>=sum(X{{ $awalBarisData + $awalBarisKosong }}:X{{ $no + $barisKosong + $awalBarisData }})</td>
        </tr>
    </tbody>
</table>
