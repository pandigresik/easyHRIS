<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:14:43
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Payrolls extends MY_Controller {
    public $title = 'Data Payrolls';

    function __construct(){
        parent::__construct();
        $this->load->model('Payroll_model','payroll_model');
        $this->model = $this->payroll_model;
    }
}

