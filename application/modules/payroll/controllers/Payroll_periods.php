<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:13:28
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Payroll_periods extends MY_Controller {
    public $title = 'Data Payroll_periods';

    function __construct(){
        parent::__construct();
        $this->load->model('Payroll_period_model','payroll_period_model');
        $this->model = $this->payroll_period_model;
    }
}

