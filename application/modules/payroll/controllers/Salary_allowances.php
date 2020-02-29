<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:15:50
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Salary_allowances extends MY_Controller {
    public $title = 'Data Salary_allowances';

    function __construct(){
        parent::__construct();
        $this->load->model('Salary_allowance_model','salary_allowance_model');
        $this->model = $this->salary_allowance_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

