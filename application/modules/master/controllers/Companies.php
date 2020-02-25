<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:31:54
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Companies extends MY_Controller {
    public $title = 'Data Companies';

    function __construct(){
        parent::__construct();
        $this->load->model('Company_model','company_model');
        $this->model = $this->company_model;
    }
}

