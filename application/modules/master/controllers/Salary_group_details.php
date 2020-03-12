<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-28 05:30:35
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Salary_group_details extends MY_Controller {
    public $title = 'Data Salary Detail';
    protected $referenceColumn = 'salary_group_id';
    function __construct(){
        parent::__construct();
        $this->load->model('Salary_group_detail_model','salary_group_detail_model');
        $this->model = $this->salary_group_detail_model;
    }
    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);        
        parent::index($referenceId);        
    }    

    public function setTitle($referenceId){
        $this->load->model('salary_group_model','sgm');                        
        $dataModel = $this->sgm->get($referenceId);        
        $this->title = 'Data '.$dataModel->name.' ( '.$dataModel->code.' )';
        parent::setTitle($referenceId);
    }
}

