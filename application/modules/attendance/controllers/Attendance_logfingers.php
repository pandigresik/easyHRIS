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

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }

    /** untuk CRUD master */
    public function prosesForm($referenceId = null)
    {
        if(empty($referenceId)){
            $key = $this->input->post('key');
            $referenceId = isset($key['id']) ? $key['id'] : NULL ;
        }

        if(!empty($referenceId)){
            $this->setTitle($referenceId);
            if(!empty($this->referenceColumn)){
                $this->filters = [$this->referenceColumn => $referenceId];
            }
        }
                
        //$this->setButtonRight($buttonFilter.'&nbsp;'.$buttonAdd);
        $this->setButtonRight('');
        $this->loadView('master/default_form', $this->setFormData());
    }

    protected function setFormData()
    {
        $awalBulan = new \Datetime();
        $akhirBulan = akhirBulan($awalBulan->format('Y-m-d'));
        $form_options = [
            'start_date' => [
                'id' => 'start_date',
                'label' => 'Tanggal Awal',
                'placeholder' => 'Tanggal Awal',
                'type' => 'input',
                'data-tipe' => 'date',
                'data-mindate' => -60,
                'value' => tglIndonesia($awalBulan->format('Y-m').'-01'),
                'readonly' => 'readonly',
                'required' => 'required',
                'input_addons' => [
                    'pre_html' => '<div class="inner-addon right-addon"><i class="glyphicon glyphicon-calendar"></i>',
                ],
            ],
            'end_date' => [
                'id' => 'end_date',
                'label' => 'Tanggal Akhir',
                'placeholder' => 'Tanggal Akhir',
                'type' => 'input',
                'data-tipe' => 'date',
                'data-mindate' => -30,
                'value' => tglIndonesia($akhirBulan),
                'readonly' => 'readonly',
                'required' => 'required',
                'input_addons' => [
                    'pre_html' => '<div class="inner-addon right-addon"><i class="glyphicon glyphicon-calendar"></i>',
                ],
            ],    
            'nik' => array(
                'id' => 'nik',
                'label' => 'Filter NIK',
                'placeholder' => 'contoh penulisan 0008753,0007944',
                'value' => '',
            ),
            'submit' => [
                'id' => 'submit',
                'type' => 'submit',
                'label' => 'Proses',
            ],
        ];
        $dataForm = array(
            'form_header' => array('data-actiontype' => 'save', 'data-nexturl' => site_url($this->pathView), 'action' => site_url($this->pathView.'/proses')),
            'form_options' => $form_options,
        );
        $divTable = $this->load->view('layout/form', $dataForm,TRUE);
        return ['table' => $divTable, 'title' => $this->title];
    }

    protected function setBtnAdd($key = null)
    {
        return generateButton('Process Log Finger', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/attendance_logfingers/prosesForm'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')
            .generateButton('Import Log', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/importAttendance_logfingers/add'),'class' => 'btn btn-dark active'],'<i class="fa fa-upload"></i>')
            .generateButton('Pull Log Mesin', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/Attendance_logfingers/pull'),'class' => 'btn btn-dark active'],'<i class="fa fa-upload"></i>')
        ;
    }

    public function proses(){
        $data = $this->input->post('data');
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $nik = !empty($data['nik']) ? explode(',',$data['nik']) : NULL;
        $result = Modules::run('attendance/process/fingerDetail',$startDate,$endDate,$nik);        
        $this->display_json($result);
    }

    public function pull(){
        $data = $this->input->post('data');
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $nik = !empty($data['nik']) ? explode(',',$data['nik']) : NULL;
        $result = Modules::run('transaksi/proses/pullFinger',$startDate,$endDate,$nik);        
        $this->display_json($result);
    }
}