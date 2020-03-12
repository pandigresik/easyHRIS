<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:22:12
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Workshifts extends MY_Controller {
    public $title = 'Data Jadwal Kerja';

    function __construct(){
        parent::__construct();
        $this->load->model('Workshift_model','workshift_model');
        $this->model = $this->workshift_model;
    }

    public function index($referenceId = NULL){        
        $this->model->setWithReferences(TRUE);        
        if(empty($this->getFilters('periode'))){
            $this->addFilters('periode',date('Y-m'));
        }

        $this->add_external_js([           
            'assets/libs/stickytable/js/jquery.stickytable.min.js',            
        ]);
        $this->add_external_css([            
            'assets/libs/stickytable/css/jquery.stickytable.min.css'
        ]);
        parent::index($referenceId);        
    }

    protected function setIndexData()
    {
        $key = $this->input->post('key');
        $periode = $this->getFilters('periode');
        $data = [
            'header' => ['periode' => $periode],
            'detail' => $this->buildDataJadwal($periode)
        ];
        $divTable = Modules::run('master/importWorkshift/generateTableJadwal',$data);
        return ['table' => $divTable, 'title' => $this->title, 'filterModal' => $this->getFilterModal()];
    }    

    protected function setBtnAdd($key = null)
    {
        return generateButton('Generate Jadwal', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('master/workshifts/generate'),'class' => 'btn btn-dark active'],'<i class="fa fa-gear"></i>')
            .generateButton('Import Jadwal', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('master/importWorkshift/add'),'class' => 'btn btn-dark active'],'<i class="fa fa-upload"></i>')
            .generateAddButton('Tambah', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add')])
        ;
    }

    public function generate()
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
            'form_header' => array('data-actiontype' => 'save', 'data-nexturl' => site_url($this->pathView), 'action' => site_url($this->pathView.'/prosesGenerate')),
            'form_options' => $form_options,
        );
        $divTable = $this->load->view('layout/form', $dataForm,TRUE);        
        $dataView = ['table' => $divTable, 'title' => 'Generate Jadwal Kerja'];
        $this->loadView($this->viewPage['index'], $dataView);
        
    }

    public function prosesGenerate(){
        $data = $this->input->post('data');
        $startDate = $data['start_date'];
        $endDate = $data['end_date'];
        $nik = !empty($data['nik']) ? explode(',',$data['nik']) : NULL;
        $result = Modules::run('transaksi/proses/fingerDetail',$startDate,$endDate,$nik);        
        $this->display_json($result);
    }
    /**
     * formatnya 
     * array('nama' => 'nama pegawai','nik' => nik pegawai', 'jabatan' => '' ,'tglmasuk' => '', 'tgl' => [] )     
     */
    private function buildDataJadwal($periode){
        $result = [];
        $awalBulan = $periode.'-01';
        $akhirBulan = akhirBulan($awalBulan);
        $tmp = $this->model->fields('employees.full_name as nama, employees.code as nik, shiftments.code as code, DAY(work_date) as work_date')->as_array()->get_many_by('work_date between \''.$awalBulan.'\' and \''.$akhirBulan.'\'');
        if(!empty($tmp)){
            foreach($tmp as $t){
                $nik = $t['nik'];
                $nama = $t['nama'];
                $shift = $t['code'];
                $tgl = $t['work_date'];
                
                if(!isset($result[$nik])){
                    $result[$nik] = [
                        'nik' => $nik,
                        'nama' => $nama,
                        'jabatan' => '',
                        'tglmasuk' => '',
                        'tanggal' => []
                    ];
                }                
                $result[$nik]['tanggal'][$tgl] = ['code' => $shift];
            }
        }        
        return $result;
    }
}

