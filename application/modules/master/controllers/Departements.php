<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:55:17
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Departements extends MY_Controller {
    public $title = 'Data Departements';

    function __construct(){
        parent::__construct();
        $this->load->model('Departement_model','departement_model');
        $this->model = $this->departement_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

