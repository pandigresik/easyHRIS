<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-28 05:23:11
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Salary_groups extends MY_Controller {
    public $title = 'Data Salary_groups';

    function __construct(){
        parent::__construct();
        $this->load->model('Salary_group_model','salary_group_model');
        $this->model = $this->salary_group_model;
    }

    public function setTableConfig()
    {
        parent::setTableConfig();
        $this->table->extra_columns = [
            'btnEdit' => [
                    'data' => generatePrimaryButton('<i class="fa fa-pencil"></i>', ['onclick' => 'App.editRecord(this)', 'data-url' => site_url($this->pathView.'/'.$this->actionMethodEdit)])
                    .' '.generateDangerButton('<i class="fa fa-recycle"></i>', ['onclick' => 'App.deleteRecord(this)', 'data-urlmessage' => site_url($this->pathView.'/deleteMessage'), 'data-nexturl' => site_url($this->pathView.'/'.$this->actionMethodIndex), 'data-url' => site_url($this->pathView.'/'.$this->actionMethodDelete)])
                    .' '.generateSuccessButton('<i class="fa fa-lock"></i>', ['onclick' => 'App.detailRecord(this)', 'data-nexturl' => site_url($this->pathView.'/'.$this->actionMethodIndex), 'data-url' => site_url('master/salary_group_details')])
                    
                ],
        ];
    }
}

