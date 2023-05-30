<table>
    <tr><td colspan="6">REKAP TOTAL DAN DAFTAR TRANSFER GAJI</td></tr>
    <tr><td>Periode </td><td colspan="5"> : {{ $periodTitle }}</td></tr>    
</table>

<table class="table table-bordered">
    <thead>
        <tr>        
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>BU</th>
            <th>Jabatan</th>
            <th>{{ $periodTitle }}</th>
            <th>Total</th>
            <th>Transfer</th>
            <th colspan="2">No. Rek</th>
        </tr>        
    </thead>
    <tbody>
        <tr>
            <td colspan="10"></td>
        </tr>
        @php
            $awalBarisData = 5;
            $barisPemisah = 5;
        @endphp
        @foreach($collection as $idEntity => $payrolls)            
            <tr>
                <td colspan="10">{{ $payrollEntity[$idEntity] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="10"></td>
            </tr>
            @foreach($payrolls as $no =>  $payroll)            
            <tr>
                <td>{{ ($no + 1) }}</td>
                <td>{{ $payroll->employee->code }}</td>
                <td>{{ $payroll->employee->full_name }}</td>
                <td>{{ $payroll->employee->businessUnit->name ?? '' }}</td>                
                <td>{{ $payroll->employee->jobtitle->name ?? '' }}</td>
                <td>{{ $payroll->getRawOriginal('take_home_pay') }}</td>
                <td>{{ $payroll->getRawOriginal('take_home_pay') }}</td>
                <td>=round({{ $payroll->getRawOriginal('take_home_pay') }},0)</td>
                <td>{{ $payroll->employee->account_bank }}</td>
                <td>{{ $payroll->employee->full_name }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">Total</td>
                <td>=sum(F{{$awalBarisData + 3}}:F{{$awalBarisData + $no + 3}})</td>
                <td>=sum(G{{$awalBarisData + 3}}:G{{$awalBarisData + $no + 3}})</td>
                <td>=sum(H{{$awalBarisData + 3}}:H{{$awalBarisData + $no + 3}})</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="10"></td>
            </tr>
            @php
                $awalBarisData += $no + $barisPemisah;
            @endphp
        @endforeach
    </tbody>
</table>
