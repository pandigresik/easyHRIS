<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:45:15
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Company_addresses extends MY_Controller {
    public $title = 'Data Company_addresses';

    function __construct(){
        parent::__construct();
        $this->load->model('Company_address_model','company_address_model');
        $this->model = $this->company_address_model;
    }
}

