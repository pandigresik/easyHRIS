<div class="text-center">
    <h3>Rekapitulasi Absensi Periode {{ localFormatDate($startDate) }} sd {{ localFormatDate($endDate) }}</h3>
</div>
<br>
<br>
<table class="table table-bordered text-center">
    <thead>        
        <tr>
            <th>Nama</th>
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
        $totalState = [];
        foreach($absentReason as $ar){
            $totalState[$ar] = 0;
        }
    @endphp
    @foreach ($dataEmployees as $empid => $emp)
        <tr>
            <td class="text-start">{{ $employees[$empid]->code_name ?? '-' }}</td>
            @foreach ($absentReason as $ar)
                @php
                    $tdClass = '';
                    $total = $emp[$ar]['total'] ?? 0;
                    if($ar != 'OK'){
                        if($total > 0){
                            $tdClass = 'text-white bg-danger';
                        }
                    }
                    $totalState[$ar] += $total;
                @endphp                
                <td class="{{ $tdClass }}">{{ $total }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            @foreach ($absentReason as $ar)
                <th>{{ $totalState[$ar] }}</th>
            @endforeach
        </tr>
    </tfoot>
</table>