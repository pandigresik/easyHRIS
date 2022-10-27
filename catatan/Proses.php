<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Proses extends MX_Controller
{
    private $startDate;
    private $endDate;
    private $nik;
    private $liburCode = ['L','N','O','R','X','LD'];
    public function __construct(){
        $this->load->model('hris/user_hris_model', 'uhris');
        $this->load->model('Jadwal_detail_model','jdm');
        $this->load->model('Absent_detail_model','adm');
        $this->load->model('Fingerprint_model','fpm');
        $this->load->model('Fingerprint_detail_model','fpdm');
        $this->load->model('Fingerprint_detail_absent_model','fpdam');
        parent::__construct();
    }

    public function fingerDetail($startDate, $endDate , $nik = []){
        //log_message('error','awal '.$startDate.' akhir '.$endDate.' nik '.json_encode($nik));
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->setNik($nik);
        $this->bersihkanData();
        $whereFilter = ['tanggalabsensi between \''.$startDate.'\' and \''.$endDate.'\''];
        if(!empty($nik)){
            $whereFilter['nik'] = $nik;
        }
        $jadwalKerja = convertArr2Key($this->jdm->as_array()->setWithTimetable(TRUE)->fields(['nik','tanggalabsensi','cast(jam_masuk as varchar(8)) as jammasuk','cast(jam_pulang as varchar(8)) as jampulang','timetables_id'])->get_many_by($whereFilter),'nik','tanggalabsensi');
        $dataFinger = convertArr2Key($this->fpm->setOriginalData(TRUE)->order_by('absen_time','asc')->fields(['nik','kodeabsensi','tanggalabsensi','absen_time'])->as_array()->get_many_by($whereFilter),'nik','tanggalabsensi',TRUE);
        return $this->isiData($dataFinger,$jadwalKerja);
    }

    private function bersihkanData(){   
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate(); 
        $nik = $this->getNik();
        $whereFilter = ['tanggalabsensi between \''.$startDate.'\' and \''.$endDate.'\''];
        if(!empty($nik)){
            $whereFilter['nik'] = $nik;
        }

        $this->fpdam->delete_by($whereFilter);
        $this->fpdm->delete_by($whereFilter);
    }

    private function getPengajuan(){   
        $result = [];
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate(); 
        $nik = $this->getNik();
        $whereFilter = ['tanggalabsensi between \''.$startDate.'\' and \''.$endDate.'\' and absents.status != \'V\''];
        if(!empty($nik)){
            $whereFilter['absent_details.nik'] = $nik;
        }

        $tmp = $this->adm->setWithHeader(TRUE)->fields(['absents.status','absent_types.is_harian','absent_details.tanggalabsensi','absent_details.nik','absent_details.start_date','absent_details.end_date'])->as_array()->get_many_by($whereFilter);
        if(!empty($tmp)){
            $result = convertArr2Key($tmp,'nik','tanggalabsensi',TRUE);
        }
        return $result;
    }

    private function pegawaiLokasiKerjaKhusus(){   
        $this->load->model('lokasi_kerja_temporary_detail_model','lktdm');
        $result = [];
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate(); 
        $nik = $this->getNik();
        $whereFilter = ['tanggalabsensi between \''.$startDate.'\' and \''.$endDate.'\' '];
        if(!empty($nik)){
            $whereFilter['nik'] = $nik;
        }

        $tmp = $this->lktdm->setWithApproveStatus(TRUE)->fields(['nik','tanggalabsensi','lokasi_tujuan'])->as_array()->get_many_by($whereFilter);
        if(!empty($tmp)){
            $result = convertArr2Key($tmp,'nik','tanggalabsensi',TRUE);
        }
        return $result;
    }
    

    private function isiData($dataFinger,$jadwalKerja){
        $result = ['status' => 0, 'message' => 'gagal proses finger absensi'];
        if(empty($jadwalKerja)){
            $result['message'] = 'Jadwal kerja tidak ditemukan di range tanggal tersebut';
            return $result;
        }
        $jmlData = 0;
        $pengajuan = $this->getPengajuan();
        $lokasiKerjaKhusus = $this->pegawaiLokasiKerjaKhusus();
        $listNik = array_keys($jadwalKerja);        
        $uhris = convertArr($this->uhris->fields(['NIK','KODELOKASI','NAMABP','NAMAJABATAN','DEPARTEMEN','DIVISI'])->as_array()->get_many_by(['NIK' => $listNik, 'FINGER' => 1]),'NIK');
        
        foreach($jadwalKerja as $nik => $pernik){
            $infoUser = isset($uhris[$nik]) ? $uhris[$nik] : [];
            $pengajuanNik = isset($pengajuan[$nik]) ? $pengajuan[$nik] : [];
            if(!empty($infoUser)){
                foreach($pernik as $tgl => $pertanggal){
                    $pengajuanPertanggal = isset($pengajuanNik[$tgl]) ? $pengajuanNik[$tgl] : [];
                    $tglpulang = $pertanggal['jammasuk'] > $pertanggal['jampulang'] ? tglSetelah(1,$tgl)->format('Y-m-d') : $tgl;
                    $detailFinger = [
                        'nik' => $nik,
                        'namabp' => $infoUser['NAMABP'],
                        'departemen' => $infoUser['DEPARTEMEN'],
                        'divisi' => $infoUser['DIVISI'],
                        'namajabatan' => $infoUser['NAMAJABATAN'],
                        'tanggalabsensi' => $tgl,
                        'jammasuk' => $tgl.' '.$pertanggal['jammasuk'],
                        'jampulang' => $tglpulang.' '.$pertanggal['jampulang'],
                        'statushari' => in_array($pertanggal['timetables_id'],$this->liburCode) ? 'L' : 'K',
                        'realisasimasuk' => NULL,
                        'realisasipulang' => NULL
                    ];
                    if($detailFinger['statushari'] != 'L'){
                        if(isset($dataFinger[$nik])){
                            if(isset($dataFinger[$nik][$tgl])){
                                $currentLokasi = $infoUser['KODELOKASI'];                       
                                if(isset($lokasiKerjaKhusus[$nik])){
                                    if(isset($lokasiKerjaKhusus[$nik][$tgl])){
                                        $currentLokasi = $lokasiKerjaKhusus[$nik][$tgl]['lokasi_tujuan'];
                                    }   
                                }
                                
                                /** pastikan finger di lokasi yang benar */
                                
                                if($dataFinger[$nik][$tgl][0]['kodeabsensi'] == $currentLokasi){
                                    $_tmpFinger = $this->klasifikasiJamFinger($dataFinger[$nik][$tgl],['jammasuk' => $tgl.' '.$pertanggal['jammasuk'], 'jampulang' => $tglpulang.' '.$pertanggal['jampulang']]);
                                    //log_message('error',json_encode($_tmpFinger));
                                    $detailFinger['realisasimasuk'] = $_tmpFinger['time_come'];
                                    $detailFinger['realisasipulang'] = $_tmpFinger['time_home'];
                                }
                            }
                        }

                        $detailFinger['bermasalah'] = $this->setBermasalah($detailFinger,$pengajuanPertanggal);
                    }
                    if($this->fpdm->insert($detailFinger)){
                        $jmlData++;
                    }else{
                       log_message('error','gagal insert '.json_encode($detailFinger)); 
                    }
                    
                }
            }
        }
        if($jmlData){
            $result['status'] = 1;
            $result['message'] = $jmlData.' data absensi berhasil ditambahkan';
        }
        return $result;
    }

    private function klasifikasiJamFinger($_timeAbsent, $defaultJamKerja)
    {
        $result = array('time_come' => null, 'time_home' => null, 'break_start' => null, 'break_end' => null);
        if (!empty($_timeAbsent) && !empty($defaultJamKerja)) {
            //$istirahatawal = FormatterWeb::formatTime($defaultJamKerja['ISTIRAHATAWAL']);
            //$istirahatakhir = FormatterWeb::formatTime($defaultJamKerja['ISTIRAHATAKHIR']);
            $breakStartValid = false;
            $breakEndValid = false;
            foreach ($_timeAbsent as $_jam) {
                $break_start = (empty($result['break_start']) or !$breakStartValid) ? true : false;
                $tmp = $this->setWaktuFinger($_jam['absen_time'], $defaultJamKerja, $break_start);

                if (!empty($tmp['type'])) {
                    switch ($tmp['type']) {
                        case 'time_come':
                            /* ambil yang minimal */
                            if (empty($result['time_come'])) {
                                $result[$tmp['type']] = $tmp['value'];
                            }
                            break;
                        
                        case 'break':
                            if (!isset($result[$tmp['type']])) {
                                $result[$tmp['type']] = array();
                            }
                            array_push($result[$tmp['type']], $tmp['value']);
                            break;
                        case 'time_home':
                            /* ambil yang maximal */
                            $result[$tmp['type']] = $tmp['value'];
                            break;
                        default:
                    }
                }
            }
        }

        /* cek kembali untuk menentukan jam istirahat */
        //$resultBreak = $this->setJamIstirahat($result['break'], array('awal' => $istirahatawal, 'akhir' => $istirahatakhir));
        //unset($result['break']);
        // $result = array_merge($result, $resultBreak);
        return $result;
    }

    private function setJamIstirahat($arrBreak, $jamIstirahat)
    {
        $result = array('break_start' => null, 'break_end' => null);
        $minBreak = date('H:i', strtotime('-1 hour', strtotime($jamIstirahat['awal'])));
        $midBreak = date('H:i', strtotime('+30 minutes', strtotime($jamIstirahat['awal'])));
        $maxBreak = date('H:i', strtotime('+1 hour', strtotime($jamIstirahat['akhir'])));
        $validBreak = array();
        $outRange = array();

        if (!empty($arrBreak)) {
            foreach ($arrBreak as $_b) {
                if ($_b >= $jamIstirahat['awal']) {
                    if ($_b <= $jamIstirahat['akhir']) {
                        array_push($validBreak, $_b);
                    } else {
                        array_push($outRange, $_b);
                    }
                } else {
                    array_push($outRange, $_b);
                }
            }

            if (!empty($outRange)) {
                foreach ($outRange as $_b) {
                    if ($_b < $jamIstirahat['awal']) {
                        $result['break_start'] = $_b;
                    }
                    if ($_b > $jamIstirahat['akhir']) {
                        $result['break_end'] = $_b;
                    }
                }
            }

            if (!empty($validBreak)) {
                if (count($validBreak) > 1) {
                    $result['break_start'] = $validBreak[0];
                    $result['break_end'] = end($validBreak);
                } else {
                    if (!empty($result['break_start'])) {
                        $result['break_end'] = $validBreak[0];
                    } elseif (!empty($result['break_end'])) {
                        $result['break_start'] = $validBreak[0];
                    } else {
                        if ($validBreak[0] < $midBreak) {
                            $result['break_start'] = $validBreak[0];
                        } else {
                            $result['break_end'] = $validBreak[0];
                        }
                    }
                }
            }
        }

        return $result;
    }

    private function setWaktuFinger($jam, $defaultJamKerja, $break_start = false)
    {
        $result = array('type' => null, 'value' => null);
        $jammasuk = $defaultJamKerja['jammasuk'];
        $jampulang = $defaultJamKerja['jampulang'];
        //$istirahatawal = FormatterWeb::formatTime($defaultJamKerja['ISTIRAHATAWAL']);
        //$istirahatakhir = FormatterWeb::formatTime($defaultJamKerja['ISTIRAHATAKHIR']);
        $type = null;
        /** maksimum masuk adalah 1 jam setelah jam masuk */
        $start = $jammasuk;
        $end = $jampulang;

        $maxMasuk = date('Y-m-d H:i', strtotime('+1 hour', strtotime($start)));
        $minPulang = date('Y-m-d H:i', strtotime('-1 hour', strtotime($end)));

        if ($jam <= $maxMasuk) {
            $type = 'time_come';
        } else {
            if ($jam < $minPulang) {
                $type = 'break';
            } else {
                $type = 'time_home';
            }
        }

        $result['type'] = $type;
        $result['value'] = substr($jam, 0, 18);

        return $result;
    }

    private function setBermasalah($detailFinger,$pengajuanPertanggal){
        $result = 0;
        $adaPengajuanHarian = 0;
        /** jika ada pengajuan harian dan sudah diapprove maka set result = 0 */
        if(!empty($pengajuanPertanggal)){
            foreach($pengajuanPertanggal as $p){
                if($p['status'] == 'I'){
                    if($p['is_harian']){
                        $result = 0;
                        $adaPengajuanHarian = 1;
                        break;
                    }else{
                        if($p['start_date'] == $detailFinger['jammasuk']){
                            $detailFinger['realisasimasuk'] = $p['start_date'];       
                        }
                        if($p['start_date'] == $detailFinger['jampulang']){
                            $detailFinger['realisasipulang'] = $p['start_date'];       
                        }
                        /** untuk case KP/KD masih belum karena belum tau data finger didapat darimana */
                    }    
                }
            }

            if($adaPengajuanHarian){
                return $result != 0 ? 'A' : NULL;     
            }
        }

        

        if(!empty($detailFinger['jammasuk'])){
            if(empty($detailFinger['realisasimasuk'])){
                $result++;
            }else{
                if($detailFinger['realisasimasuk'] > $detailFinger['jammasuk']){
                    $result++;
                }
            }        
        }

        if(!empty($detailFinger['jampulang'])){
            if(empty($detailFinger['realisasipulang'])){
                $result++;
            }else{
                if($detailFinger['realisasipulang'] < $detailFinger['jampulang']){
                    $result++;
                }
            }        
        }
        
        return $result != 0 ? 'A' : NULL; 
    }

    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of nik
     */ 
    public function getNik()
    {
        return $this->nik;
    }

    /**
     * Set the value of nik
     *
     * @return  self
     */ 
    public function setNik($nik)
    {
        $this->nik = $nik;

        return $this;
    }
}
