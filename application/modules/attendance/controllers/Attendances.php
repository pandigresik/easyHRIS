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
        return generateButton('Process Summary Attendance', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('master/workshifts/generate'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')            
            .generateAddButton('Tambah', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add')])
        ;
    }
}

