<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Process extends MY_Controller
{
    private $startDate;
    private $endDate;
    private $employeeId;
    private $holiday;
    /** batas karyawan absent setelah jam pulang, asumsinya max lembur juga mengikuti */
    private $maxHourAttendance = '+4 hour';
    /** batas karyawan absent sebelum jam masuk, asumsinya max lembur juga mengikuti untuk lembur awal kerja */
    private $minHourAttendance = '-4 hour';
    /** batas minimum dianggap sebagai lembur */
    private $minOvertime = 30;
    private $liburCode = ['SHFL'];
    public function __construct(){        
        $this->load->model('workshift_model','wm');
        $this->load->model('leafe_model','lm');
        $this->load->model('attendance_logfinger_model','alm');
        $this->load->model('attendance_model','am');        
        $this->load->model('overtime_model','om');        
        $this->load->model('holiday_model','hm');            
        parent::__construct();
    }

    public function fingerDetail($startDate, $endDate , $employeeId = []){        
        $this->setStartDate($startDate);
        $this->setEndDate($endDate);
        $this->setHolidayDateRange($startDate,$endDate);
        $this->setNik($employeeId);
        $this->bersihkanData();
        $whereFilter = ['work_date between \''.$startDate.'\' and \''.$endDate.'\''];
        
        $jadwalKerja = convertArr2Key($this->wm->as_array()->setWithReferences(TRUE)->fields(['have_overtime_benefit','employee_id','work_date','shiftments.start_hour as jammasuk','shiftments.end_hour as jampulang','shiftment_id','shiftments.code as shift_code'])->get_many_by($whereFilter),'employee_id','work_date');
        $whereFilterFinger = ['fingertime between \''.$startDate.' 00:00:00\' and \''.$endDate.' 23:59:59\''];
        $dataFinger = convertArr2Key($this->alm->fields(['employee_id','fingertime','work_date'])->as_array()->get_many_by($whereFilterFinger),'employee_id','work_date',TRUE);
        return $this->isiData($dataFinger,$jadwalKerja);
    }

    private function setHolidayDateRange($startDate,$endDate){
        $result = [];
        $tmp = $this->hm->as_array()->fields(['holiday_date'])->get_many_by('holiday_date between \''.$startDate.'\' and \''.$endDate.'\'');
        if(!empty($tmp)){
            $result = array_column($tmp,'holiday_date');
        }

        $this->setHoliday($result);
    }

    private function bersihkanData(){   
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate(); 
        $employeeId = $this->getNik();
        $whereFilter = ['attendance_date between \''.$startDate.'\' and \''.$endDate.'\''];
        /*if(!empty($employeeId)){
            $whereFilter['nik'] = $employeeId;
        }*/

        $this->am->delete_by($whereFilter);   
        $whereFilterOvertime = ['overtime_date between \''.$startDate.'\' and \''.$endDate.'\''];
        $this->om->delete_by($whereFilterOvertime);   
    }

    private function getLeaveAbsent(){   
        $result = [];
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate(); 
        $employeeId = $this->getNik();
        $whereFilter = [' leave_date between \''.$startDate.'\' and \''.$endDate.'\' and deleted_at is null '];
        /*if(!empty($employeeId)){
            $whereFilter['absent_details.nik'] = $employeeId;
        }*/
        $tmp = $this->lm->fields(['leave_date','employee_id','reason_id'])->as_array()->get_many_by($whereFilter);
        if(!empty($tmp)){
            $result = convertArr2Key($tmp,'employee_id','leave_date',TRUE);
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
        $pengajuan = $this->getLeaveAbsent();        
        
        foreach($jadwalKerja as $employeeId => $pernik){            
            $pengajuanNik = isset($pengajuan[$employeeId]) ? $pengajuan[$employeeId] : [];
            if(!empty($pernik)){                
                foreach($pernik as $tgl => $pertanggal){
                    $haveOvertimeBenefit = $pertanggal['have_overtime_benefit'];
                    $pengajuanPertanggal = isset($pengajuanNik[$tgl]) ? $pengajuanNik[$tgl] : [];
                    $tglpulang = $pertanggal['jammasuk'] > $pertanggal['jampulang'] ? tglSetelah(1,$tgl)->format('Y-m-d') : $tgl;
                    $detailFinger = [
                        'employee_id' => $employeeId,                        
                        'attendance_date' => $tgl,
                        'shift_checkin' => $tgl.' '.$pertanggal['jammasuk'],
                        'shift_checkout' => $tglpulang.' '.$pertanggal['jampulang'],
                        'absent' => in_array($pertanggal['shift_code'],$this->liburCode) ? 1 : 0,                        
                        'shiftment_id' => $pertanggal['shiftment_id'],
                        'reason_id' => !empty($pengajuanPertanggal) ? $pengajuanPertanggal['reason_id'] : NULL
                    ];
                    if(!$detailFinger['absent']){
                        $detailFinger['absent'] = 1;
                        if(isset($dataFinger[$employeeId])){
                            if(isset($dataFinger[$employeeId][$tgl])){
                                $_defaultJamKerja = ['jammasuk' => $tgl.' '.$pertanggal['jammasuk'], 'jampulang' => $tglpulang.' '.$pertanggal['jampulang']];
                                $_tmpFinger = $this->klasifikasiJamFinger($dataFinger[$employeeId][$tgl],$_defaultJamKerja);                                                                  
                                $detailFinger['check_in'] = $_tmpFinger['time_come'];

                                if(!empty($detailFinger['check_in'])){
                                    if($detailFinger['check_in'] <= $_defaultJamKerja['jammasuk']){
                                        $detailFinger['early_in'] = dateDifference($detailFinger['check_in'],$_defaultJamKerja['jammasuk'],'%i');
                                    }else{
                                        $detailFinger['late_in'] = dateDifference($_defaultJamKerja['jammasuk'],$detailFinger['check_in'],'%i');
                                    }
                                }
                                                                
                                $detailFinger['check_out'] = $_tmpFinger['time_home'];
                                if(!empty($detailFinger['check_out'])){
                                    if($detailFinger['check_out'] <= $_defaultJamKerja['jampulang']){
                                        $detailFinger['early_out'] = dateDifference($detailFinger['check_out'],$_defaultJamKerja['jampulang'],'%i');
                                    }else{
                                        $detailFinger['late_out'] = dateDifference($_defaultJamKerja['jampulang'],$detailFinger['check_out'],'%i');
                                    }
                                }
                                
                                /** jika check_in dan check_out kosong berarti karyawan tidak masuk kerja */
                                if(!empty($detailFinger['check_in']) || !empty($detailFinger['check_out'])){
                                    $detailFinger['absent'] = 0;
                                }                                
                            }
                        }
                        //$detailFinger['bermasalah'] = $this->setBermasalah($detailFinger,$pengajuanPertanggal);
                    }

                    $this->am->insert($detailFinger);
                    if($haveOvertimeBenefit){                        
                        if($detailFinger['early_in'] >= $this->minOvertime){
                            $this->setOvertime($detailFinger,'earlyOvertime');
                        }
                        if($detailFinger['late_out'] >= $this->minOvertime){
                            $this->setOvertime($detailFinger,'lateOvertime');
                        }
                    }
                                        
                    $jmlData++;                                                                
                }
            }
        }
        if($jmlData){
            $result['status'] = 1;
            $result['message'] = $jmlData.' data absensi berhasil ditambahkan';
        }
        return $result;
    }

    private function setOvertime($detailFinger, $type = 'lateOvertime'){
        $data = [
            'employee_id' => $detailFinger['employee_id'],
            'overtime_date' => $detailFinger['attendance_date'],                      
            'shiftment_id' => $detailFinger['shiftment_id'],
            'holiday' => 0
        ];

        if(!empty($this->getHoliday())){
            if(in_array($detailFinger['attendance_date'],$this->getHoliday())){
                $data['holiday'] = 1;
            }
        }

        switch($type){
            case 'earlyOvertime':
                $data['start_hour'] = $detailFinger['check_in'];
                $data['end_hour'] = $detailFinger['shift_checkin'];            
                $data['raw_value'] = $detailFinger['early_in'];
                break;
            default:
                $data['start_hour'] = $detailFinger['shift_checkout'];
                $data['end_hour'] = $detailFinger['check_out'];  
                $data['raw_value'] = $detailFinger['late_out'];          
        }
        /*$whereFilter = [
            'employee_id' => $data['employee_id'],
            'overtime_date' => $data['overtime_date'],                      
            'start_hour' => $data['start_hour']
        ];*/                  
        //$this->om->saveData($whereFilter,$data);
        $this->om->insert($data);
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
                //$break_start = (empty($result['break_start']) or !$breakStartValid) ? true : false;
                $break_start = false;
                $tmp = $this->setWaktuFinger($_jam['fingertime'], $defaultJamKerja, $break_start);

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

        $maxMasuk = date('Y-m-d H:i', strtotime($this->maxHourAttendance, strtotime($start)));
        $minMasuk = date('Y-m-d H:i', strtotime($this->minHourAttendance, strtotime($start)));
        $maxPulang = date('Y-m-d H:i', strtotime($this->maxHourAttendance, strtotime($end)));

        if ($jam <= $maxMasuk && $jam >= $minMasuk) {
            $type = 'time_come';
        } else {
            /*if ($jam < $minPulang) {
                $type = 'break';
            } else {
                $type = 'time_home';
            }*/
            if ($jam > $maxMasuk && $jam <= $maxPulang) {
                $type = 'time_home';
            }            
        }

        $result['type'] = $type;
        $result['value'] = substr($jam, 0, 18);

        return $result;
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
    public function setNik($employeeId)
    {
        $this->nik = $employeeId;

        return $this;
    }

    /**
     * Get the value of holiday
     */ 
    public function getHoliday()
    {
        return $this->holiday;
    }

    /**
     * Set the value of holiday
     *
     * @return  self
     */ 
    public function setHoliday($holiday)
    {
        $this->holiday = $holiday;

        return $this;
    }
}
