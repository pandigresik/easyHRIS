<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:00:04
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Employees extends MY_Controller {
    public $title = 'Data Employees';

    function __construct(){
        parent::__construct();
        $this->load->model('Employee_model','employee_model');
        $this->model = $this->employee_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

