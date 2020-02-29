<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Jadwal extends MY_Controller
{
    public $title = 'Jadwal Kerja';
    private $filterNik = [];
    private $markToday = FALSE;
    private $actualJadwal = FALSE;
    private $timetable;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('jadwal_model', 'jadwal');
        $this->model = $this->jadwal;
        $this->load->model('timetables_model', 'ttable');
    }

    public function index($referenceId = null)
    {
        if(!$this->isAdministrator()){
            $this->addFilters('created_by', $this->getIdUser());
        }
        
        parent::index($referenceId);
    }

    public function active($referenceId = null)
    {
        $this->addFilters('created_by', $this->getIdUser());        
        $this->addFilters('status', ['A']);
        parent::index($referenceId);
    }

    public function approvalList($referenceId = null)
    {
        $this->addFilters('user_approval', $this->getIdUser());
        $this->addFilters('status', ['A']);
        parent::index($referenceId);
    }

    public function setTableConfig()
    {
        $this->table->key_record = array($this->model->getKeyName());
        $this->table->setHiddenField(['id', 'status_asli']);
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
            $this->load->model('hris/User_hris_model', 'uhris');
            $jabatanAtasan = $this->getJabatanAtasan();
            $listPenyetuju = $this->uhris->getNikJabatanAtasan($jabatanAtasan);

            $optionPenyetuju = [];
            if (!empty($listPenyetuju)) {
                foreach ($listPenyetuju as $_idUser => $lp) {
                    array_push($optionPenyetuju, '<option value="'.$_idUser.'">'.$lp['NAMA'].' - '.$lp['NAMAJABATAN'].'</option>');
                }
            }

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
                        <div class="form-group">
                            <label class="col-md-3">Penyetuju</label>
                            <div class="col-md-9">
                                <select class="form-control" name="user_approval" required><option value="">Pilih penyetuju</option>'.implode(' ', $optionPenyetuju).'</select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        '.generateButton('<a href="uploads/template/jadwal_kerja.xls" >Unduh Template Jadwal Kerja</a>', ['class' => 'btn btn-default'], '<i class="fa fa-file-pdf-o"></i>').'
                    </div>
                </div>';
        } else {
            $status = $this->config->item('status');
            $approvalBtn = '';
            $this->load->model('hris/User_hris_model', 'uhris');
            $this->load->model('User_model', 'um');
            $nikPenyetuju = $this->um->fields('ref_nik')->get($data['user_approval']);
            $userPenyetuju = $this->uhris->fields('NAMABP,NAMAJABATAN')->get_by(['NIK' => $nikPenyetuju->ref_nik]);
            $namaPenyetuju = $userPenyetuju->NAMABP.' - '.$userPenyetuju->NAMAJABATAN;
            if ($this->canApprove($data)) {
                $approvalBtn = generatePrimaryButton('Approve', ['onclick' => 'Jadwal.approve(this)', 'data-id' => $data['id']]).' '.generateDangerButton('Reject', ['onclick' => 'Jadwal.reject(this)', 'data-id' => $data['id']]);
            }
            $comment = $data['status_asli'] == $status['rejected'] ? '<span style="margin-left:50px"> - '.$data['comment'].'</span>' : '';

            if ($data['status_asli'] == $status['inactive']) {
                if(!$this->getFilterNik()){
                    $comment = '<div class="pull-right"><div style="margin-left:50px">'.generateButton('<a href="'.$data['attachment'].'" >Cetak</a>', ['class' => 'btn btn-default'], '<i class="fa fa-print"></i>').'</div></div>';
                }
            }

            return '<div class="row">
                        <form class="form form-horizontal">    
                        <div class="">
                            <div class="form-group">
                                <label class="col-md-2">Status Pengajuan</label>
                                <div class="col-md-10">
                                    '.$data['status'].$comment.'
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-2">Detail Persetujuan</label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2">Persetujuan 1</label>
                                <div class="col-md-10">
                                    '.$namaPenyetuju.'
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-offset-2 col-md-10">
                                    '.$approvalBtn.'
                                </div>
                            </div>
                        </div>
                        </form>
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
        $ada = $this->model->count_by(['periode' => $periode, 'kodeorg' => $kodeorg, 'status' => ['I', 'A']]);
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
        $this->load->model('User_model', 'um');
        $nikTidakAktif = $this->um->fields('ref_nik')->as_array()->get_many_by(['ref_nik' => $listNik, 'status' => ['I']]);
        if (!empty($nikTidakAktif)) {
            array_push($result, 'Nik berikut ini <br /> <span class="red">'.implode(',', array_column($nikTidakAktif, 'ref_nik')).' </span><br /> tidak aktif');
        } else {
            $result = $this->periksaNikBelumUpload($kodeorg, $listNik);
        }

        return $result;
    }

    private function periksaNikBelumUpload($kodeorg, $listNik)
    {
        $result = [];
        $this->load->model('hris/User_hris_model', 'uhris');
        $tmp = $this->uhris->checkNikUpload($kodeorg, $listNik);
        if (!empty($tmp)) {
            foreach ($tmp as $t) {
                if (empty($t['REF_NIK'])) {
                    array_push($result, $t['NIK'].' '.$t['NAMABP'].' '.$t['NAMAORG'].' belum diupload');
                }

                if (empty($t['NIK'])) {
                    array_push($result, $t['REF_NIK'].' bukan karyawan departemen ini');
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
            1 => ['name' => 'departemen', 'value' => 32],
            2 => ['name' => 'periode', 'value' => 32],
            3 => ['name' => 'kodeorg', 'value' => 32],
            4 => ['name' => 'jumlah_karyawan', 'value' => 32],
        ];
        
        $timetable = convertArr($this->ttable->fields('id,1 as value')->as_array()->get_many_by(['status' => 'A']), 'id');
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
            2 => 'nik',
            3 => 'nama',
            4 => 'jabatan',
            5 => 'tglmasuk',
        ];

        foreach ($row as $k => $r) {
            $tgl = $k - 5;
            if ($k > 5) {
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
                    $result['data']['tanggal'][$tgl] = $r;
                }
            } else {
                if ($k >= 2) {
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

    private function currentJadwal($detail,$periode){
        /** cek apakah ada pengajuan untuk user dalam detail */
        $nik = array_keys($detail);
        $awalBulan = $periode.'-01';
        $akhirBulan = LastDateOfMonth($awalBulan)->format('Y-m-d');
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
        unset($data['file_name']);
        if (empty($where)) {
            $where = [$this->model->getKeyName() => null];
            $data['status'] = $status['active'];
            $data['no_pengajuan'] = $this->model->getNoPengajuan();
            $data['created_by'] = $this->getIdUser();
            $data['attachment'] = $pathFile;
        }
        $headerOnly = true;
        $arr = $this->bacaFile($pathFile, $headerOnly);
        $header = $arr['header'];
        $data = array_merge($data, $header);

        $saved = $this->model->saveData($where, $data);
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

    private function saveDetail($id)
    {
        $this->load->model('Jadwal_detail_model', 'jdm');
        $data = $this->model->as_object()->fields('attachment,periode')->get($id);
        $periode = $data->periode;
        $arr = $this->bacaFile($data->attachment);
        $detail = $arr['detail'];
        $tmp = [];
        list($year, $month) = explode('-', $periode);
        $jmlhari = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        foreach ($detail as $d) {
            $nik = $d['nik'];
            foreach ($d['tanggal'] as $tgl => $timetable) {
                if ($tgl <= $jmlhari) {
                    array_push($tmp, ['jadwal_id' => $id, 'nik' => $nik, 'timetables_id' => $timetable, 'tanggalabsensi' => $periode.'-'.$tgl]);
                }
            }
        }
        $this->jdm->insert_many($tmp);
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
