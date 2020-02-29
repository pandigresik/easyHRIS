<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/** Generate by crud generator model pada 2019-02-27 11:41:47
 *   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
 *   Author afandi.
 */
class Activitylog extends MY_Controller
{
    public $title = 'Data Aktivitas User (Transaksi)';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('activity_log_model', 'alm');
        $this->model = $this->alm;
        //$this->addFilters('nik', $this->getNIK());
    }

    public function setTableConfig()
    {
        $this->table->setHiddenField(['id']);
        $this->table->key_record = array($this->model->getKeyName());
        $this->table->extra_columns = [
            'btnEdit' => [
                    'data' => generatePrimaryButton('<i class="fa fa-file"></i>', ['onclick' => 'App.detailRecord(this)', 'data-url' => site_url($this->pathView.'/'.$this->actionMethodEdit)])
                ],
        ];
    }


    protected function setBtnAdd($key = null)
    {
        return;
    }

    public function searchAjax()
    {
        //$_POST['data'] = 'nik = \''.$this->getNIK().'\' and tanggalabsensi < cast(getdate() as date)';
        parent::searchAjax();
    }

    protected function defaultFilterPage()
    {
        $filterUrl = isset($this->filters['route']) ? $this->filters['route'] : null;
        $filterData = isset($this->filters['send_data']) ? $this->filters['send_data'] : null;
        
        $form_options = [
            'filter_log' => [
                'id' => 'filter_log',
                'label' => 'Filter',
                'type' => 'combine',
                'elements' => [
                    [
                        'id' => 'route',
                        'type' => 'input',
                        'value' => $filterUrl,
                        'placeholder' => 'Ketikkan url',
                        'input_addons' => [
                            'pre_html' => '<div class="col-md-3">',
                        ],
                    ],
                    [
                        'label' => 'Data',
                        'id' => 'send_data',
                        'placeholder' => 'ketikkan data',
                        'type' => 'input',
                        'value' => $filterData,
                        'input_addons' => [
                            'pre_html' => '<div class="col-md-3">',
                        ],
                    ],
                    [
                        'id' => 'search',
                        'type' => 'submit',
                        'label' => html_entity_decode('&#xf002;'),
                        'class' => 'fa-input',
                        'input_addons' => [
                            'pre_html' => '<div class="col-md-1">',
                        ],
                    ],
                ],
            ],
        ];
        $this->form_builder->init([
            'default_control_label_class' => 'col-sm-1 control-label',
            'default_form_control_class' => 'col-sm-11',
        ]);
        $dataForm = array(
            'form_header' => array('data-actiontype' => 'search', 'action' => site_url($this->pathView.'/search')),
            'form_options' => $form_options,
        );
        $this->filterPage = '<div class="col-md-12">'.$this->load->view('layout/form', $dataForm, true).'</div>';
    }

    /**
     * Get the value of filters.
     */
    public function getFilters($key = null)
    {
        $result = null;
        $result = is_null($key) ? $this->filters : (isset($this->filters[$key]) ? $this->filters[$key] : null);
        if(isset($result['route'])){
            $route = $result['route'];
            unset($result['route']);
            array_push($result, ' route like \'%'.$route.'%\'');
        }
        if(isset($result['send_data'])){
            $send_data = $result['send_data'];
            unset($result['send_data']);
            array_push($result, ' send_data like \'%'.$send_data.'%\'');
        }
        return $result;
    }

    public function edit(){
        if(isset($_POST['key'])){
            if(isset($_POST['key']['id'])){
                $key = $_POST['key']['id'];
                unset($_POST['key']['id']);
                $_POST['key']['activity_log.id'] = $key;
            }
            

        }
        parent::edit();
    }
}

