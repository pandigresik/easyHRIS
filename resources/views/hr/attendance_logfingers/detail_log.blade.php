<h4>Data Fingerprint {{ $workshift->employee->full_name }} ( {{ $workshift->employee->code }} ) Tanggal {{ $workshift->work_date }} </h4>
<div class="table-responsive">    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Waktu Absensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendanceLogfinger as $log)
                <tr>                    
                    <td>{{ $log->fingertime }}</td>
                </tr>
            @empty
            <tr>
                <td>Data tidak ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>