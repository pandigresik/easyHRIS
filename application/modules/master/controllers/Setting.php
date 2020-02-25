<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 11:09:36
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Setting extends MY_Controller {
    public $title = 'Data Settings';

    function __construct(){
        parent::__construct();
        $this->load->model('Setting_model','setting_model');
        $this->model = $this->setting_model;
    }
}

