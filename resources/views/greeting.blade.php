<div class="container">
    <div class="col-10 offset-1 card border-primary">
        <div class="card-header">
            <div class="d-flex align-items-center">
            <div class="bg-primary p-1">
                <img src="vendor/images/logo.png">    
            </div>
            <div class="p-2 flex-fill pt-3 pl-5">
                <h2>Selamat Datang Aplikasi Payroll LJP</h2>
            </div> 
        </div>
        </div>
        <div class="card-body">            
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-danger" style="cursor:pointer" data-url='{{ route('hr.attendanceLogfingers.index') }}' data-target="_parent" data-tipe="get" onclick="main.redirectUrl(this)">
                            <div class="card-header"><h4>Attendance Log</h4></div> 
                            <div class="card-body bg-danger">
                                <div class="card-text text-white">
                                    Menu untuk manajemen data log finger karyawan
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-warning" style="cursor:pointer" data-url='{{ route('hr.attendances.index') }}' data-target="_parent" data-tipe="get" onclick="main.redirectUrl(this)">
                            <div class="card-header"><h4>Attendance</h4></div> 
                            <div class="card-body bg-warning">
                                <div class="card-text text-danger">
                                    Menu untuk manajemen data absensi karyawan
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-primary" style="cursor:pointer" data-url='{{ route('hr.overtimes.index') }}' data-target="_parent" data-tipe="get" onclick="main.redirectUrl(this)">
                            <div class="card-header"><h4>Overtime</h4></div> 
                            <div class="card-body bg-primary">
                                <div class="card-text text-white">
                                    Menu untuk manajemen data lembur karyawan
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-success" style="cursor:pointer" data-url='{{ route('hr.requestWorkshifts.index') }}' data-target="_parent" data-tipe="get" onclick="main.redirectUrl(this)">
                            <div class="card-header"><h4>Ganti Shift Pekerja</h4></div> 
                            <div class="card-body bg-success">
                                <div class="card-text text-white">
                                    Menu untuk perubahan jadwal kerja karyawan yang bersifat sementara
                                </div>
                            </div>
                        </div>        
                    </div>
                    <div class="col-md-4 col-sm-12 mb-2">
                        <div class="card border-info" style="cursor:pointer" data-url='{{ route('hr.workshifts.index') }}' data-target="_parent" data-tipe="get" onclick="main.redirectUrl(this)">
                            <div class="card-header"><h4>Workshift</h4></div> 
                            <div class="card-body bg-info">
                                <div class="card-text text-white">
                                    Menu untuk manajemen jadwal kerja karyawan
                                </div>
                            </div>
                        </div>        
                    </div>
                </div>                                
            </div>
        </div>
        <div class="card-footer">
            <div class="col-md-12 mt5"> Langgeng Jaya Group didirikan sejak tahun 2006. Hingga kini memiliki 2 anak perusahaan yaitu, PT Langgeng Jaya Plastindo dan PT Langgeng Jaya Fiberindo. Kami telah hadir melalui rangkaian produk seperti <b>Gilingan / Cacahan Poliester (PET), Peletan PP, LDPE, HDPE, Poliester (PET) Karung Woven &amp; FIBC / Jumbo Bag, PSF (Polyester Staple Fiber), Non-Woven Needle Punch, Padding &amp; High Density Padding, Spunbond, Tali Strapping Poliester (PET), PVD (Prefabricated Vertical Drain) dan Tas Belanja ramah lingkungan</b>. Didukung dua pabrik yang beroperasi di Gresik dan Tangerang, serta ribuan karyawan berpengalaman dan profesional. </div>
        </div>
    </div>    
</div>
@push('breadcrumb')
    Dashboard
@endpush