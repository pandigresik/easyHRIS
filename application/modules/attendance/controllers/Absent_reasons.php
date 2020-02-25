<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:26:34
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Absent_reasons extends MY_Controller {
    public $title = 'Data Absent_reasons';

    function __construct(){
        parent::__construct();
        $this->load->model('Absent_reason_model','absent_reason_model');
        $this->model = $this->absent_reason_model;
    }
}

