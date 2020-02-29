<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-29 20:14:24
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Shiftment_groups extends MY_Controller {
    public $title = 'Data Shiftment_groups';

    function __construct(){
        parent::__construct();
        $this->load->model('Shiftment_group_model','shiftment_group_model');
        $this->model = $this->shiftment_group_model;
    }

    public function index($referenceId = NULL){
        $this->model->setWithReferences(TRUE);
        parent::index($referenceId);        
    }
}

