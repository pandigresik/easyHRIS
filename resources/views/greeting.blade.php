<div class="container">
    <div class="col-10 offset-1 card border-primary">
        <div class="card-header">
            <div class="d-flex align-items-center">
            <div class="bg-primary p-1">
                <img src="{{ getLogoApp() }}">    
            </div>
            <div class="p-2 flex-fill pt-3 pl-5">
                <h2>Selamat Datang di Aplikasi Payroll LJP</h2>
            </div> 
        </div>
        </div>
        <div class="card-body">            
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-danger" style="cursor:pointer">
                            <div class="card-header"><h4>Attendance Log</h4></div> 
                            <div class="card-body bg-danger">
                                <div class="card-text text-white">
                                    Menu untuk manajemen data log finger karyawan
                                </div>
                                <a href="{{ route('hr.attendanceLogfingers.index') }}" class="btn btn-info">Go </a>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-warning" style="cursor:pointer">
                            <div class="card-header"><h4>Attendance</h4></div> 
                            <div class="card-body bg-warning">
                                <div class="card-text text-danger">
                                    Menu untuk manajemen data absensi karyawan
                                </div>
                                <a href="{{ route('hr.attendances.index') }}" class="btn btn-info">Go </a>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-primary" style="cursor:pointer">
                            <div class="card-header"><h4>Overtime</h4></div> 
                            <div class="card-body bg-primary">
                                <div class="card-text text-white">
                                    Menu untuk manajemen data lembur karyawan
                                </div>
                                <a href="{{ route('hr.overtimes.index') }}" class="btn btn-danger">Go </a>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-success" style="cursor:pointer">
                            <div class="card-header"><h4>Ganti Shift Pekerja</h4></div> 
                            <div class="card-body bg-success">
                                <div class="card-text text-white">
                                    Menu untuk perubahan jadwal kerja karyawan yang bersifat sementara
                                </div>
                                <a href="{{ route('hr.requestWorkshifts.index') }}" class="btn btn-info">Go </a>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-info" style="cursor:pointer">
                            <div class="card-header"><h4>Workshift</h4></div> 
                            <div class="card-body bg-info">
                                <div class="card-text text-white">
                                    Menu untuk manajemen jadwal kerja karyawan
                                </div>
                                <a href="{{ route('hr.workshifts.index') }}" class="btn btn-danger">Go </a>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-warning" style="cursor:pointer">
                            <div class="card-header"><h4>Attendance Report</h4></div> 
                            <div class="card-body bg-warning">
                                <div class="card-text text-danger">
                                    Rekapitulasi absensi karyawan
                                </div>
                                <a href="{{ route('hr.attendanceReports.index') }}" class="btn btn-success">Go </a>
                            </div>
                        </div>        
                    </div>
                </div>                                
            </div>
        </div>
        <div class="card-footer">
            <div class="col-md-12 mt5">{{ env('GREETING_DASHBOARD', '') }}</div>
        </div>
    </div>    
</div>
@push('breadcrumb')
    Dashboard
@endpush