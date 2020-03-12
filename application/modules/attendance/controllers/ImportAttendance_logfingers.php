<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ImportAttendance_logfingers extends MY_Controller
{
    public $title = 'Upload Log Finger';
    private $filterNik = [];
    private $markToday = FALSE;
    private $actualJadwal = FALSE;
    private $timetable;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Attendance_logfinger_model','attendance_logfinger_model');
        $this->model = $this->attendance_logfinger_model;
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
            'assets/js/attendance/logFinger.js'
        ]);
        $this->add_external_css([
            'assets/libs/dropzone/dist/min/basic.min.css',
        ]);

        parent::add($referenceId);
    }
    
    protected function _formEdit($data = array(), $where = array())
    {
        $this->setButtonRight();
        
        $dataForm = array(
            'form_header' => array('data-actiontype' => 'save', 'data-nexturl' => site_url($this->pathView.'/'.$this->actionMethodIndex), 'action' => site_url($this->pathView.'/'.$this->actionMethodSave)),
            'entry_form' => $this->getEntryForm($data),
            'table' => '',
        );        
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
                        <div>File yang dapat diunggah adalah file XLS dengan format isian sesuai dengan format yang ditentukan</div>
                        <div><label>File yang diunggah : </label></div>
                        <div><input class="form-control" type="text" name="file_name" readonly /></div>
                        <div class="hide"><input type="text" name="attachment"  /></div>
                        <br />                        
                    </div>
                    <div class="col-md-3">
                        '.generateButton('<a href="uploads/template/log_fingertime.xls" >Unduh Template Jadwal Kerja</a>', ['class' => 'btn btn-default'], '<i class="fa fa-file-pdf-o"></i>').'
                    </div>
                </div>';
        } 
    }

    public function uploadFile()
    {
        $config = array(
            'upload_path' => 'uploads/logfinger',
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
        $updatedData = 0;
        $_message = [];
        $arr = $this->bacaFile($pathFile);        
        if(!empty($arr)){
            /** get id employee */
            $this->load->model('employee_model','em');            
            $employeeId = convertArr($this->em->fields(['id','code'])->as_array()->get_many_by(['code' => array_keys($arr)]),'code');                        
            /** get id machine finger */            
            $this->load->model('fingerprint_device_model','fdm');            
            $fingerprintId = convertArr($this->fdm->as_array()->fields(['id','serial_number'])->as_array()->get_all(),'serial_number');                        
            foreach($arr as $_nik => $tmp){                
                if(isset($employeeId[$_nik])){
                    foreach($tmp as $_tmp){
                        $where = ['employee_id' => $employeeId[$_nik]['id'],'fingertime' => $_tmp['fingertime']];
                        $_tmp['fingerprint_device_id'] = isset($fingerprintId[$_tmp['serial_number']]) ? $fingerprintId[$_tmp['serial_number']]['id'] : NULL;                        
                        $_tmp['employee_id'] = $employeeId[$_nik]['id'];
                        $_tmp['work_date'] = substr($_tmp['fingertime'],0,10);
                        unset($_tmp['serial_number']);
                        unset($_tmp['nik']);
                        $this->model->saveData($where,$_tmp);    
                        $updatedData++;
                    }
                    
                }                
            }
            $result['status'] = 1;
            $result['message'] = $updatedData.' data telah disimpan';            
        }        

        return $result;
    }

    private function bacaFile($fileName)
    {
        $result = [];
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        if($extension == 'csv'){
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
        } elseif($extension == 'xlsx') {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        } else {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        }

        // file path
        $spreadsheet = $reader->load($fileName);
        $allDataInSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);                
        $maxHeaderIndex = 2;                                
        foreach ($allDataInSheet as $k => $row) {                        
            if ($k < $maxHeaderIndex) continue;
            $tmp = $this->parseDetail($row);            
            if(!isset($result[$tmp['nik']])){
                $result[$tmp['nik']] = [];    
            }
            array_push($result[$tmp['nik']],$tmp);
        }

        return $result;
    }

    private function parseDetail($row)
    {
        $result = [];        
        $indexDetail = [
            'B' => 'nik',            
            'D' => 'type_absen',
            'E' => 'fingertime',
            'F' => 'serial_number'
        ];

        foreach ($row as $k => $r) {                        
            if(isset($indexDetail[$k])){                
                $result[$indexDetail[$k]] = $r;            
            } 
        }

        return $result;
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
}
