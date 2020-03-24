<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:22:55
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Attendances extends MY_Controller {
    public $title = 'Data Attendances';

    function __construct(){
        parent::__construct();
        $this->load->model('Attendance_model','attendance_model');
        $this->model = $this->attendance_model;        
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }

    protected function setBtnAdd($key = null)
    {
        return generateButton('Process Summary Attendance', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('attendance/attendances/generate'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')            
            .generateAddButton('Tambah', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add')])
        ;
    }

    public function generate()
    {
        $date = new \DateTime();
        $date->sub(new \DateInterval('P1M'));
        $currMonth = new \DateTime();
        $optionPeriode = [];
        while($date <= $currMonth){
            array_push($optionPeriode,$date->format('Y-m'));
            $date->add(new \DateInterval('P1M'));            
        }
        $form_options = [
            'periode' => [
                'id' => 'periode',
                'label' => 'Periode',
                'placeholder' => 'Tanggal Awal',
                'type' => 'dropdown',
                'class' => 'select2_single',
                'options' => $optionPeriode,                
                'value' => '',                
                'required' => 'required'                
            ],
            'submit' => [
                'id' => 'submit',
                'type' => 'submit',
                'label' => 'Proses',
            ],
        ];
        $dataForm = array(
            'form_header' => array('data-actiontype' => 'save', 'data-nexturl' => site_url($this->pathView), 'action' => site_url($this->pathView.'/prosesGenerate')),
            'form_options' => $form_options,
        );
        $divTable = $this->load->view('layout/form', $dataForm,TRUE);        
        $dataView = ['table' => $divTable, 'title' => 'Generate Summary Attendance'];
        $this->loadView('master/default_form', $dataView);        
    }

    public function prosesGenerate(){
        $periode = $this->input->post('periode');        
        /** pastikan attendance sudah fix dan data overtime juga sudah fix */        
        $result = Modules::run('attendance/process/summaryAttendance',$periode);        
        $this->display_json($result);
    }
}

