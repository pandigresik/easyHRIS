<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:20:36
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Tax_group_history extends MY_Controller {
    public $title = 'Data Tax_group_history';

    function __construct(){
        parent::__construct();
        $this->load->model('Tax_group_history_model','tax_group_history_model');
        $this->model = $this->tax_group_history_model;
    }
}

