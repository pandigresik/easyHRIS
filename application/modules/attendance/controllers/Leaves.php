<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:08:25
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Leaves extends MY_Controller {
    public $title = 'Data Leaves';

    function __construct(){
        parent::__construct();
        $this->load->model('Leafe_model','leafe_model');
        $this->model = $this->leafe_model;
    }
}

