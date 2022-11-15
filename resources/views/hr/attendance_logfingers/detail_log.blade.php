<h3>Data absensi karyawan</h3>
<div class="table-responsive">    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>NIK</th>
                <th>Waktu Absensi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($attendanceLogfinger as $log)
                <tr>
                    <td>{{ $log->employee->full_name }}</td>
                    <td>{{ $log->employee->code }}</td>
                    <td>{{ $log->fingertime }}</td>
                </tr>
            @empty
            <tr>
                <td colspan="3">Data tidak ditemukan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>