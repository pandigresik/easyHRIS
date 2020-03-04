<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ImportWorkshift extends MY_Controller
{
    public $title = 'Jadwal Kerja';
    private $filterNik = [];
    private $markToday = FALSE;
    private $actualJadwal = FALSE;
    private $timetable;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('workshift_model', 'workshift');
        $this->model = $this->workshift;
        $this->load->model('shiftment_model', 'shiftment');
    }        

    public function setTableConfig()
    {
        $this->table->key_record = array($this->model->getKeyName());
        $this->table->setHiddenField(['id']);
        $this->table->extra_columns = ['btnEdit' => [
            'data' => generateButton('<i class="fa fa-file"></i>', ['onclick' => 'App.editRecord(this)', 'data-url' => site_url($this->pathView.'/'.$this->actionMethodEdit)]), ],
            ];
    }

    public function add($referenceId = null)
    {
        $this->add_external_js([
            'assets/libs/dropzone/dist/min/dropzone.min.js',
            'assets/libs/stickytable/js/jquery.stickytable.min.js',
            'assets/js/master/jadwal.js'
        ]);
        $this->add_external_css([
            'assets/libs/dropzone/dist/min/basic.min.css',
            'assets/libs/stickytable/css/jquery.stickytable.min.css'
        ]);

        parent::add($referenceId);
    }

    public function edit()
    {
        $this->add_external_js([
            'assets/libs/stickytable/js/jquery.stickytable.min.js',
            'assets/js/master/jadwal.js'
        ]);
        $this->add_external_css([
            'assets/libs/stickytable/css/jquery.stickytable.min.css'
        ]);
        
        parent::edit();
    }

    protected function _formEdit($data = array(), $where = array())
    {
        $this->setButtonRight();
        $dataForm = array(
            'form_header' => array('data-actiontype' => 'save', 'data-nexturl' => site_url($this->pathView.'/'.$this->actionMethodIndex), 'action' => site_url($this->pathView.'/'.$this->actionMethodSave)),
            'entry_form' => $this->getEntryForm($data),
            'table' => '',
        );

        if (empty($data)) {
            $dataForm['actions'] = ['text' => 'Simpan', 'option' => ['class' => 'btn btn-success pull-right', 'onclick' => 'return Jadwal.simpan(this)']];
        } else {
            $arr = $this->bacaFile($data['attachment']);
            $dataForm['table'] = $this->tableJadwal($arr);
        }
        $this->loadView('master/jadwal_kerja_form', $dataForm);
    }

    private function getEntryForm($data = array())
    {
        if (empty($data)) {            
            return '<div class="row" style="height:75%">
                    <div class="col-md-3">
                        <div class="dropzone" data-url="'.$this->pathView.'/uploadFile">
                            <div class="dz-message text-center">
                                <div style="margin-top:10%"><h4>Seret dan letakkan file disini </h4>atau</div>
                                <div>'.generateButton('Pilih file', ['class' => 'btn btn-default'], '<i class="fa fa-file"></i>').'</div>
                            </div>                        
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div><strong>Perhatian !</strong></div>
                        <div>File yang dapat diunggah adalah file XLS & XLSX dengan format isian sesuai dengan format yang ditentukan</div>
                        <div><label>File yang diunggah : </label></div>
                        <div><input class="form-control" type="text" name="file_name" readonly /></div>
                        <div class="hide"><input type="text" name="attachment"  /></div>
                        <br />                        
                    </div>
                    <div class="col-md-3">
                        '.generateButton('<a href="uploads/template/jadwal_kerja.xls" >Unduh Template Jadwal Kerja</a>', ['class' => 'btn btn-default'], '<i class="fa fa-file-pdf-o"></i>').'
                    </div>
                </div>';
        } 
    }

    public function uploadFile()
    {
        $config = array(
            'upload_path' => 'uploads/jadwal',
            'allowed_types' => 'xls|xlsx',
            'max_size' => 10240,
        );
        $result = $this->do_upload('userfile', $config);
        $fileName = '';
        if ($result['status']) {
            $fileName = $config['upload_path'].'/'.$result['data']['upload_data']['file_name'];
            // $pathFile = $result['data']['upload_data']['full_path'];
            $result = $this->periksaFile($fileName);
        }
        $result['attachment'] = $fileName;
        $this->display_json($result);
    }

    private function periksaFile($pathFile)
    {
        $result = ['status' => 0, 'message' => ''];
        $_message = [];
        $arr = $this->bacaFile($pathFile);
        if (empty($arr['error'])) {
            $arr['error'] = $this->periksaPeriode($arr['header']);
            if (empty($arr['error'])) {
                $arr['error'] = $this->periksaNik($arr['detail'], $arr['header']['kodeorg']);
            }

            if (empty($arr['error'])) {
                $result['content'] = $this->tableJadwal($arr);
                $result['status'] = 1;
            } else {
                $result['message'] = $arr['error'];
            }
        }else{
            $result['message'] = $arr['error'];
        }

        return $result;
    }

    /** pastikan periode untuk departemen tersebut belum ada dengan status in ('A','I') */
    private function periksaPeriode($header)
    {        
        $result = [];
        $periode = $header['periode'];
        $kodeorg = $header['kodeorg'];
        $tglAwal = $periode.'-01';
        $tglAkhir = akhirBulan($tglAwal);
        $ada = $this->model->count_by('work_date between \''.$tglAwal.'\'and \''.$tglAkhir.'\'');
        if ($ada) {
            list($year, $month) = explode('-', $periode);
            array_push($result, 'Periode <span class="blue">'.convert_ke_bulan($month).' '.$year.'</span> sudah ada');
        }

        return $result;
    }

    /** cari karyawan yang non aktif */
    private function periksaNik($detail, $kodeorg)
    {
        $result = [];
        $listNik = array_keys($detail);
        $this->load->model('Employee_model', 'pm');
        $nikTidakAktif = $this->pm->fields('code')->as_array()->get_many_by(['code' => $listNik, 'resign_date is not null']);
        if (!empty($nikTidakAktif)) {
            array_push($result, 'Nip berikut ini <br /> <span class="red">'.implode(',', array_column($nikTidakAktif, 'code')).' </span><br /> tidak aktif');
        } else {
            $result = $this->periksaNikBelumUpload($kodeorg, $listNik);
        }

        return $result;
    }

    private function periksaNikBelumUpload($kodeorg, $listNik)
    {
        $result = [];
        $this->load->model('Employee_model', 'pm');
        $tmp = $this->pm->as_array()->fields(['code','full_name'])->get_many_by('resign_date is null and code not in (\''.implode("','",$listNik).'\')');
        if (!empty($tmp)) {
            foreach ($tmp as $t) {
                if (!empty($t['code'])) {
                    array_push($result, $t['code'].' '.$t['full_name'].' belum diupload');
                }                
            }
        }

        return $result;
    }

    private function bacaFile($pathFile, $headerOnly = false)
    {
        $result = ['header' => [], 'title' => [], 'detail' => [], 'error' => []];
        $this->load->library('xlsreader');
        $excel = new SpreadsheetReader($pathFile);
        $maxHeaderIndex = 5;
        $indexHeader = [
            1 => ['name' => 'departemen', 'value' => 31],
            2 => ['name' => 'periode', 'value' => 31],
            3 => ['name' => 'kodeorg', 'value' => 31],
            4 => ['name' => 'jumlah_karyawan', 'value' => 31],
        ];
        
        $timetable = convertArr($this->shiftment->fields('code,id')->as_array()->get_many_by('1 = true'), 'code');
        $this->setTimetable($timetable);
        $jmlhari = 0;
        foreach ($excel as $k => $row) {
            if ($headerOnly) {
                if ($k > $maxHeaderIndex) {
                    break;
                }
            }

            if ($k < $maxHeaderIndex) {
                $result['header'][$indexHeader[$k]['name']] = $row[$indexHeader[$k]['value']];
                
                if ($indexHeader[$k]['name'] == 'periode') {
                    list($year, $month) = explode('-', $row[$indexHeader[$k]['value']]);
                    $jmlhari = cal_days_in_month(CAL_GREGORIAN, intval($month), intval($year));
                }
            } elseif ($k == $maxHeaderIndex) {
                unset($row[0]);
                $result['title'] = $row;
            } else {
                if (empty($row[2])) {
                    continue;
                }

                $detail = $this->parseDetail($row, $k, $jmlhari);
                
                if (!empty($detail['error'])) {
                    array_push($result['error'], $detail['error']);
                    break;
                } else {
                    $nikPegawai = $detail['data']['nik'];
                    if (isset($result['detail'][$nikPegawai])) {
                        array_push($result['error'], ['NIK '.$nikPegawai.' diinput lebih dari 1 kali']);
                        break;
                    }
                    if(!empty($this->filterNik)){
                        if(in_array($nikPegawai,$this->getFilterNik())){
                            $result['detail'][$nikPegawai] = $detail['data'];    
                        }
                    }else{
                        $result['detail'][$nikPegawai] = $detail['data'];
                    }
                }
            }
        }

        return $result;
    }

    private function parseDetail($row, $baris, $jmlhari)
    {
        $result = ['data' => ['tanggal' => []], 'error' => []];
        $timetable = $this->getTimetable();

        $indexDetail = [
            1 => 'nik',
            2 => 'nama',
            3 => 'jabatan',
            4 => 'tglmasuk',
        ];

        foreach ($row as $k => $r) {
            
            $tgl = $k - 4;
            if ($k > 4) {
                $r = trim($r);
                if (empty($r)) {
                    array_push($result['error'], 'Jam kerja karyawan belum diisi baris ke '.($baris));
                    break;
                } else {
                    if ($tgl > $jmlhari) {
                        continue;
                    }

                    if (!isset($timetable[$r])) {
                        array_push($result['error'], 'Kode timetable '.$r.' di baris '.($baris).' tidak terdaftar');
                        break;
                    }
                    $result['data']['tanggal'][$tgl] = $timetable[$r];
                }
            } else {
                if ($k >= 1) {
                    $result['data'][$indexDetail[$k]] = $r;
                }
            }
        }

        return $result;
    }

    private function tableJadwal($arr)
    {
        $header = $arr['header'];
        $detail = $arr['detail'];
        if($this->getActualJadwal()){
            $periode = $header['periode'];
            $detail = $this->currentJadwal($detail,$periode);
        }
        return $this->load->view('master/table_jadwal', [
            'header' => $header,
            'detail' => $detail,
            'markToday' => $this->getMarkToday()
        ], true);
    }

    public function generateTableJadwal($arr){                
        return $this->tableJadwal($arr);             
    }

    private function currentJadwal($detail,$periode){
        /** cek apakah ada pengajuan untuk user dalam detail */
        /*$nik = array_keys($detail);
        $awalBulan = $periode.'-01';
        $akhirBulan = akhirBulan($awalBulan);
        $this->load->model('absent_detail_model','adm');
        $nikPengajuan = $this->adm->setWithHeader(TRUE)->as_array()->distinct()->fields(['absent_details.nik','absent_details.tanggalabsensi'])->where([['absent_details.nik' => $nik]])->get_many_by(['absents.status = \'I\' and absent_details.tanggalabsensi between \''.$awalBulan.'\' and \''.$akhirBulan.'\'']);
        if(!empty($nikPengajuan)){
            $nikJadwal = array_column($nikPengajuan,'nik');
            $tanggalJadwal = array_column($nikPengajuan,'tanggalabsensi');
            $this->load->model('jadwal_detail_model','jdm');
            $jadwalActual = convertArr2Key($this->jdm->as_array()->fields(['nik','tanggalabsensi','timetables_id'])->get_many_by(['nik' => $nikJadwal, 'tanggalabsensi' => $tanggalJadwal]),'nik','tanggalabsensi');            
            //log_message('error',json_encode($jadwalActual));
            if(!empty($jadwalActual)){
                foreach($jadwalActual as $nik => $pertanggal){
                    foreach($pertanggal as $tgl => $val){
                        if(isset($detail[$nik])){
                            $tglSaja = explode('-',$tgl);
                            $angkaTgl = intval($tglSaja[2]);
                            if(isset($detail[$nik]['tanggal'][$angkaTgl])){
                                $detail[$nik]['tanggal'][$angkaTgl] = $val['timetables_id'];
                            }   
                        }
                    }
                }
            }
        }
*/
      //log_message('error',$periode);
        return $detail;
    }

    public function save()
    {
        $data = $this->input->post('data');
        $where = $this->input->post('key');
        $status = $this->config->item('status');
        $pathFile = '';
        if (isset($where['attachment'])) {
            $pathFile = $where['attachment'];
            unset($where['attachment']);
        }
        
        $saved = $this->saveDetail($pathFile);         
	if($saved){
	     $this->result['status'] = 1;
	     $this->result['message'] = 'Jadwal kerja berhasil diupload';	
	}else{
	     $this->result['message'] = 'Jadwal kerja gagal diupload';	
	}

        $this->display_json($this->result);
    }

    public function reject()
    {
        $data = $this->input->post('data');
        $where = $this->input->post('key');
        $status = $this->config->item('status');
        $data['status'] = $status['rejected'];

        $saved = $this->model->saveData($where, $data);
        if ($saved) {
            $this->result['status'] = 1;
            $this->result['message'] = 'Jadwal kerja berhasil direject';
        }

        $this->display_json($this->result);
    }

    public function approve()
    {
        $data = [];
        $where = $this->input->post('key');
        $status = $this->config->item('status');
        $data['status'] = $status['inactive'];
        $this->db->trans_begin();

        $saved = $this->model->saveData($where, $data);
        /* insert detail ke jadwal_detail */
        $this->saveDetail($where['id']);
        if ($this->db->trans_status() === false) {
            $this->result['message'] = 'Approval jadwal kerja gagal disimpan';
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
            $this->result['status'] = 1;
            $this->result['message'] = 'Approval jadwal kerja berhasil disimpan';
        }

        $this->display_json($this->result);
    }

    private function canApprove($data)
    {
        $result = 0;
        $status = $this->config->item('status');
        $userApproval = [$this->getIdUser()];
        if ($data['status_asli'] == $status['active']) {
            if (in_array($data['user_approval'], $userApproval)) {
                $result = 1;
            }
        }

        return $result;
    }

    private function saveDetail($attachment)
    {                        
        $this->load->model('Employee_model', 'pm');
        $arr = $this->bacaFile($attachment);        
        $detail = $arr['detail'];
        $header = $arr['header'];        
        $periode = $header['periode'];
        $niks = array_keys($detail);
        $idEmployee = convertArr($this->pm->fields('code,id')->as_array()->get_many_by(['code' => $niks]), 'code');
        $tmp = [];
        list($year, $month) = explode('-', $periode);
        $jmlhari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        foreach ($detail as $d) {
            $nik = $d['nik'];
            if(isset($idEmployee[$nik])){
                $idUser = $idEmployee[$nik]['id'];
                foreach ($d['tanggal'] as $tgl => $timetable) {
                    if ($tgl <= $jmlhari) {
                        array_push($tmp, ['employee_id' => $idUser, 'shiftment_id' => $timetable['id'], 'work_date' => $periode.'-'.$tgl]);
                    }
                }
            }            
        }
        if(!empty($tmp)){
            return $this->model->insert_many($tmp);
        }        
    }

    /**
     * Get the value of timetable.
     */
    public function getTimetable()
    {
        return $this->timetable;
    }

    /**
     * Set the value of timetable.
     *
     * @return self
     */
    public function setTimetable($timetable)
    {
        $this->timetable = $timetable;
    }

    /** override */
    protected function setBtnAdd($key = null)
    {
        $routeAddButton = $this->pathView.'/'.$this->actionMethodAdd;

        if ($this->getAccessPermission($routeAddButton)) {
            return generateAddButton('Jadwal', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add')]);
        }

        return '';
    }

    public function getHariLibur(){
        $this->load->model('jadwal_detail_model', 'jadwal_detail');
        $nik = $this->getNIK();
        
        $data = $this->jadwal_detail->as_array()->fields(['tanggalabsensi'])->get_many_by(['nik' => $nik, 'timetables_id' => 'L',' tanggalabsensi >= cast(getdate() - 30 as date)']);                    
        if(!empty($data)){
            $this->result['status'] = 1;
            $this->result['content'] = array_column($data,'tanggalabsensi');
        }
        $this->display_json($this->result);
    }
    /** tampilkan data jadwal dirinya sendiri dan bawahannya */
    public function karyawan(){
        $this->setActualJadwal(TRUE);
        $this->load->model('jadwal_detail_model', 'jdm');
        $periodeTerpilih = $this->input->post('periode');
        if(empty($periodeTerpilih)){
            $tanggalTerpilih = date('Y-m-d');
        }else{
            $tanggalTerpilih = date($periodeTerpilih.'-01');
        }
        
        $idJadwal = $this->jdm->fields(['jadwal_id'])->get_by(['nik' => $this->getNIK(), 'tanggalabsensi' => $tanggalTerpilih]);
        if(!empty($idJadwal)){
            $this->load->model('User_model', 'um');
            $_POST['key'] = ['id' => $idJadwal->jadwal_id];
            $bawahan = $this->getBawahan();
            $nikBawahan = array_column($this->um->as_array()->fields('ref_nik')->get_many(array_keys($bawahan)),'ref_nik');
            $this->setFilterNik($nikBawahan);
            $this->setMarkToday(TRUE);
            $this->edit();
        }else{
            echo 'Data jadwal tidak ditemukan untuk tanggal '.tglIndonesia($tanggalTerpilih);
        }
    }

    /**
     * Get the value of filterNik
     */ 
    public function getFilterNik()
    {
        return $this->filterNik;
    }

    /**
     * Set the value of filterNik
     *
     * @return  self
     */ 
    public function setFilterNik($filterNik)
    {
        $this->filterNik = $filterNik;
    }

    /**
     * Get the value of markToday
     */ 
    public function getMarkToday()
    {
        return $this->markToday;
    }

    /**
     * Set the value of markToday
     *
     * @return  self
     */ 
    public function setMarkToday($markToday)
    {
        $this->markToday = $markToday;
    }

    /**
     * Get the value of actualJadwal
     */ 
    public function getActualJadwal()
    {
        return $this->actualJadwal;
    }

    /**
     * Set the value of actualJadwal
     *
     * @return  self
     */ 
    public function setActualJadwal($actualJadwal)
    {
        $this->actualJadwal = $actualJadwal;
        return $this;
    }
}
