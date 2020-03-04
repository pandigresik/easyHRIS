<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-03-05 05:27:05
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Attendance_logfingers extends MY_Controller {
    public $title = 'Data Attendance_logfingers';

    function __construct(){
        parent::__construct();
        $this->load->model('Attendance_logfinger_model','attendance_logfinger_model');
        $this->model = $this->attendance_logfinger_model;
    }

    protected function setBtnAdd($key = null)
    {
        return generateButton('Generate Summary', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/attendance_logfingers/prosesGenerate'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')
            .generateButton('Import Log', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/importAttendance_logfingers/add'),'class' => 'btn btn-dark active'],'<i class="fa fa-upload"></i>')
            .generateButton('Pull Log Mesin', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/Attendance_logfingers/pull'),'class' => 'btn btn-dark active'],'<i class="fa fa-upload"></i>')
        ;
    }

    public function prosesGenerate(){
        $data = $this->input->post('data');
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $nik = !empty($data['nik']) ? explode(',',$data['nik']) : NULL;
        $result = Modules::run('transaksi/proses/fingerDetail',$startDate,$endDate,$nik);        
        $this->display_json($result);
    }

    public function pull(){
        $data = $this->input->post('data');
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $nik = !empty($data['nik']) ? explode(',',$data['nik']) : NULL;
        $result = Modules::run('transaksi/proses/fingerDetail',$startDate,$endDate,$nik);        
        $this->display_json($result);
    }
}

