<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:17:47
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Salary_benefits extends MY_Controller {
    public $title = 'Data Salary_benefits';

    function __construct(){
        parent::__construct();
        $this->load->model('Salary_benefit_model','salary_benefit_model');
        $this->model = $this->salary_benefit_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

