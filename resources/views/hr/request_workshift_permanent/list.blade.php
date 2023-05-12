<div class="text-center">
    <h3>Simulasi Jadwal Baru Periode {{ localFormatDate($startDate) }} sd {{ localFormatDate($endDate) }}</h3>
</div>
<br>
<br>
<table class="table table-bordered text-center">
    <thead>        
        <tr>
            <th rowspan="2">Tanggal</th>
            @foreach ($periodRange as $date)
                <th colspan="2">{{ localFormatDate($date->format('Y-m-d')) }} <br>{{ $workshifts[$date->format('Y-m-d')]['shiftment']['name'] ?? '-' }}</th>
            @endforeach
        </tr>
        <tr>            
            @foreach ($periodRange as $date)
                <th>Start Hour</th><th>End Hour</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($employees as $emp)
            <tr>
                <td>{{ $emp->codeName }}</td>
                @foreach ($periodRange as $date)
                    <td>{{ $workshifts[$date->format('Y-m-d')]['start_hour'] ?? 'not defined' }}</td>
                    <td>{{ $workshifts[$date->format('Y-m-d')]['end_hour'] ?? 'not defined'}}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
    
</table>