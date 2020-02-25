<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:01:11
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Holidays extends MY_Controller {
    public $title = 'Data Holidays';

    function __construct(){
        parent::__construct();
        $this->load->model('Holiday_model','holiday_model');
        $this->model = $this->holiday_model;
    }
}

