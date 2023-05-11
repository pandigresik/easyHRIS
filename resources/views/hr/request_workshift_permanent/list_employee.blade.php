<div class="text-center">
    <h3>Rekapitulasi Absensi Periode {{ localFormatDate($startDate) }} sd {{ localFormatDate($endDate) }}</h3>
</div>
<br>
<br>
<table class="table table-bordered text-center">
    <thead>        
        <tr>
            <th>Nama</th>
            <th>NIK</th>
        @foreach ($absentReason as $ar)
            <th>{{ $ar }}</th>
        @endforeach
        </tr>
    </thead>
    <tbody>
    @php
        $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
        
        $dataEmployees = $datas->sortBy('code')->groupBy('employee_id' , true)->map(function($item){
            return $item->keyBy('state');
        });
        
        // $dataEmployees = $datas->groupBy('employee_id' , true)->map(function($item){
        //     return $item->keyBy('state');
        // });
        
        $totalState = [];
        foreach($absentReason as $k => $ar){
            $totalState[$k] = 0;
        }
    @endphp
    @foreach ($dataEmployees as $empid => $emp)
        <tr>
            <td class="text-start">{{ $employees[$empid]->full_name ?? '-' }}</td>
            <td class="text-start">{{ $employees[$empid]->code ?? '-' }}</td>
            @foreach ($absentReason as $k => $ar)
                @php
                    $tdClass = '';
                    $total = $emp[$k]['total'] ?? 0;
                    if($k != 'OK'){
                        if($total > 0){
                            $tdClass = 'text-white bg-danger';
                        }
                    }
                    $totalState[$k] += $total;
                @endphp                
                <td class="{{ $tdClass }}">{{ $total }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            @foreach ($absentReason as $k => $ar)
                <th>{{ $totalState[$k] }}</th>
            @endforeach
        </tr>
    </tfoot>
</table>