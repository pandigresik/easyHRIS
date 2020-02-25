<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:06:13
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Job_titles extends MY_Controller {
    public $title = 'Data Job_titles';

    function __construct(){
        parent::__construct();
        $this->load->model('Job_title_model','job_title_model');
        $this->model = $this->job_title_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

