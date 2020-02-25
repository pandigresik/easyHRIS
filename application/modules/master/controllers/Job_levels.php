<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:03:01
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Job_levels extends MY_Controller {
    public $title = 'Data Job_levels';

    function __construct(){
        parent::__construct();
        $this->load->model('Job_level_model','job_level_model');
        $this->model = $this->job_level_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

