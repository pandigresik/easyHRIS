<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:46:39
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Company_costs extends MY_Controller {
    public $title = 'Data Company_costs';

    function __construct(){
        parent::__construct();
        $this->load->model('Company_cost_model','company_cost_model');
        $this->model = $this->company_cost_model;
    }
}

