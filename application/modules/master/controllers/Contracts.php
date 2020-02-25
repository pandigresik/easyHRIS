<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:53:57
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Contracts extends MY_Controller {
    public $title = 'Data Contracts';

    function __construct(){
        parent::__construct();
        $this->load->model('Contract_model','contract_model');
        $this->model = $this->contract_model;
    }
}

