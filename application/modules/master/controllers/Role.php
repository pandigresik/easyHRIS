<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Role extends MY_Controller
{
    public $title = 'Data Role / Peran';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_model','roles');
        $this->model = $this->roles;
    }

    public function setTableConfig()
    {
        parent::setTableConfig();
        $this->table->extra_columns = [
            'btnEdit' => [
                    'data' => generatePrimaryButton('<i class="fa fa-pencil"></i>', ['onclick' => 'App.editRecord(this)', 'data-url' => site_url($this->pathView.'/'.$this->actionMethodEdit)])
                    .' '.generateDangerButton('<i class="fa fa-recycle"></i>', ['onclick' => 'App.deleteRecord(this)', 'data-urlmessage' => site_url($this->pathView.'/deleteMessage'), 'data-nexturl' => site_url($this->pathView.'/'.$this->actionMethodIndex), 'data-url' => site_url($this->pathView.'/'.$this->actionMethodDelete)])
                    .' '.generateSuccessButton('<i class="fa fa-lock"></i>', ['onclick' => 'App.detailRecord(this)', 'data-nexturl' => site_url($this->pathView.'/'.$this->actionMethodIndex), 'data-url' => site_url('master/role_permission')])
                    
                ],
        ];
    }
}
