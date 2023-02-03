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
        $dataDate = $datas->groupBy(function($item){
            return $item->getRawOriginal('attendance_date');
        } , true)->map(function($item){
            return $item->keyBy('state');
        });        
    @endphp
    @foreach ($period as $date)
        <tr>
            <td>{{ localFormatDate($date) }}</td>
            @foreach ($absentReason as $ar)
                <td>{{ $dataDate[$date->format('Y-m-d')][$ar]['total'] ?? 0  }}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>    
</table>