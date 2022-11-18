<table>
    <tr><td colspan="6">REKAP TOTAL DAN DAFTAR TRANSFER GAJI HARIAN</td></tr>
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
            <td colspan="11"></td>
        </tr>
        @foreach($collection as $idEntity => $payrolls)
            @php
                $totalSalary = 0;
            @endphp
            <tr>
                <td colspan="11">{{ $payrollEntity[$idEntity] ?? '-' }}</td>
            </tr>
            <tr>
                <td colspan="11"></td>
            </tr>
            @foreach($payrolls as $no =>  $payroll)
            @php
                $totalSalary += $payroll->getRawOriginal('take_home_pay');
            @endphp
            <tr>
                <td>{{ ($no + 1) }}</td>
                <td>{{ $payroll->employee->code }}</td>
                <td>{{ $payroll->employee->full_name }}</td>
                <td>{{ $payroll->employee->businessUnit->name ?? '' }}</td>                
                <td>{{ $payroll->employee->jobTitle->name ?? '' }}</td>
                <td>{{ $payroll->getRawOriginal('take_home_pay') }}</td>
                <td>{{ $payroll->getRawOriginal('take_home_pay') }}</td>
                <td>{{ $payroll->getRawOriginal('take_home_pay') }}</td>
                <td>{{ $payroll->employee->account_bank }}</td>
                <td>{{ $payroll->employee->full_name }}</td>
            </tr>
            @endforeach
            <tr>
                <td colspan="5">Total</td>
                <td>{{ $totalSalary }}</td>
                <td>{{ $totalSalary }}</td>
                <td>{{ $totalSalary }}</td>
                <td colspan="2"></td>
            </tr>
            <tr>
                <td colspan="11"></td>
            </tr>
        @endforeach
    </tbody>
</table>
