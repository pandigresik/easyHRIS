<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:12:37
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Payroll_details extends MY_Controller {
    public $title = 'Data Payroll_details';

    function __construct(){
        parent::__construct();
        $this->load->model('Payroll_detail_model','payroll_detail_model');
        $this->model = $this->payroll_detail_model;
    }
}

