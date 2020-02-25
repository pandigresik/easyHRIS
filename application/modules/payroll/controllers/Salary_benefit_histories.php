<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:17:01
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Salary_benefit_histories extends MY_Controller {
    public $title = 'Data Salary_benefit_histories';

    function __construct(){
        parent::__construct();
        $this->load->model('Salary_benefit_history_model','salary_benefit_history_model');
        $this->model = $this->salary_benefit_history_model;
    }
}

