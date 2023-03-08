<div>
    <div class="text-center">
        <h4>Rekapitulasi Data Lembur Karyawan <br> {{ localFormatDate($startDate) }} sd {{ localFormatDate($endDate) }}</h4>
    </div>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                @foreach ($period as $date)
                <th>{{ $date->format('d M Y') }}</th>
                @endforeach
                <th>Total</th>
            </tr>
        </thead>
    <tbody>    
@forelse ($datas as $emp => $data)
    <tr>
        <td>
            {{ $employees[$emp]->full_name }}
        </td>
        <td>
            {{ $employees[$emp]->code }}
        </td>
        @foreach ($period as $date)
            <td class="text-end">{{ $excel ? (minuteToHour($data[$date->format('Y-m-d')]->total ?? 0)) : localNumberFormat(minuteToHour($data[$date->format('Y-m-d')]->total ?? 0), 1) }}</td>
        @endforeach
        <td class="text-end">{{ $excel ? (minuteToHour($data->sum('total'))) : localNumberFormat(minuteToHour($data->sum('total')), 2) }}</td>  
    </tr>
@empty
  <td colspan={{ count($period) + 2 }}>Data tidak ditemukan</td>  
@endforelse
</tbody>
</table>
</div>