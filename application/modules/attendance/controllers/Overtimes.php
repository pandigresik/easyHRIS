<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:11:36
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Overtimes extends MY_Controller {
    public $title = 'Data Overtimes';

    function __construct(){
        parent::__construct();
        $this->load->model('Overtime_model','overtime_model');
        $this->model = $this->overtime_model;
    }
}

