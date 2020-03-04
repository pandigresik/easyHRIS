<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:14:43
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Payrolls extends MY_Controller {
    public $title = 'Data Payrolls';

    function __construct(){
        parent::__construct();
        $this->load->model('Payroll_model','payroll_model');
        $this->model = $this->payroll_model;
    }

    protected function setBtnAdd($key = null)
    {
        return generateButton('Process Payroll', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('master/workshifts/generate'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')
            .generateButton('Process PPh 21', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('master/workshifts/generate'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')
            .generateAddButton('Tambah', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add')])
        ;
    }
}

