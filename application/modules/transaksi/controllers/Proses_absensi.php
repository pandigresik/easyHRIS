<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Proses_absensi extends MY_Controller
{
    public $title = 'Proses Data Finger Absensi';
    protected $showButtonLeft = false;
    protected $showButtonRight = false;

    protected function setIndexData()
    {
        $form_options = [
            'start_date' => [
                'id' => 'start_date',
                'label' => 'Tanggal Awal',
                'placeholder' => 'Tanggal Awal',
                'type' => 'input',
                'data-tipe' => 'date',
                'data-mindate' => -60,
                'value' => '',
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
                'value' => '',
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

    public function proses(){
        $data = $this->input->post('data');
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $nik = !empty($data['nik']) ? explode(',',$data['nik']) : NULL;
        $result = Modules::run('transaksi/proses/fingerDetail',$startDate,$endDate,$nik);        
        $this->display_json($result);
    }
}
