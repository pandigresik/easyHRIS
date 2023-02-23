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
            <td colspan=8>PENERIMAAN</td>
            <td colspan=8>POTONGAN</td>          					
            <th rowspan="2">Gaji Netto</th>
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
            <td>NETTO</td>
        </tr>        
    </thead>
    <tbody>
        @php
            $awalBarisData = 6;
            $no = 0;
        @endphp
        @foreach($payrolls as $no =>  $payroll)
        @php
            $additionalInfo = $payroll->additional_info;
            $payrollDetails = $payroll->payrollDetails->keyBy('component_id');            
            $salaryComponent = $payrollDetails[$component['GP']] ?? [];            
            $overtimeComponent = $payrollDetails[$component['OT']] ?? [];
            $sundayOvertimeComponent = $payrollDetails[$component['TUMLM']] ?? [];
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

            
            
        @endphp
        <tr>
            <td>{{ $no + 1 }}</td>
            <td>{{ $payroll->employee->code }}</td>
            <td>{{ $payroll->employee->full_name }}</td>
            <td>{{ $payroll->employee->businessUnit->name ?? '' }}</td>
            <td>{{ $payroll->employee->department->name ?? '' }}</td>
            <td>{{ $payroll->employee->jobtitle->name ?? '' }}</td>                                   
            <td>{{ $salaryComponent->getRawOriginal('benefit_value') ?? 0 }}</td>                        
            <td>{{ $positionComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $otherComponent ? $otherComponent->getRawOriginal('benefit_value') : 0 }}</td>
            <td>{{ $premiComponent->getRawOriginal('benefit_value') ?? 0 }}</td>
            <td>{{ $overtimeSalary }}</td>            
            <td>{{ $overtimeComponent->getRawOriginal('benefit_value') ?? 0 }}</td>            
            <td>{{ $uangMakanComponent ? ($uangMakanComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>
            <td>{{ $uangMakanLemburComponent ? ($uangMakanLemburComponent->getRawOriginal('benefit_value') ?? 0) : 0 }}</td>            
            <td>{{ $totalPenerimaan }}</td>            
            <td>{{ $absent }}</td>
            <td>{{ $absent * $dailySalary }}</td>            
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
            <td colspan="6"></td>
            <td>=sum(G{{ $awalBarisData }}:G{{ $no + $awalBarisData }})</td>
            <td>=sum(H{{ $awalBarisData }}:H{{ $no + $awalBarisData }})</td>
            <td>=sum(I{{ $awalBarisData }}:I{{ $no + $awalBarisData }})</td>
            <td>=sum(J{{ $awalBarisData }}:J{{ $no + $awalBarisData }})</td>
            <td>=sum(K{{ $awalBarisData }}:K{{ $no + $awalBarisData }})</td>            
            <td>=sum(L{{ $awalBarisData }}:L{{ $no + $awalBarisData }})</td>            
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
        </tr>
    </tbody>
</table>
