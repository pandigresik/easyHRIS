<div class="text-center">
    <h3>Rekapitulasi Absensi Periode {{ localFormatDate($startDate) }} sd {{ localFormatDate($endDate) }}</h3>
</div>
<br>
<br>
<table class="table table-bordered text-center">
    <thead>        
        <tr>
            <th>Tanggal</th>
        @foreach ($absentReason as $ar)
            <th>{{ $ar }}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
    @php
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        $dataEmployees = $datas->groupBy('employee_id' , true)->map(function($item){
            return $item->keyBy('state');
        });        
    @endphp
    @foreach ($dataEmployees as $emp)
        <tr>
            <td class="text-start">{{ $emp['OK']->employee->code_name ?? '-' }}</td>
            @foreach ($absentReason as $ar)
                <td>{{ $emp[$ar]['total'] ?? 0  }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>    
</table>