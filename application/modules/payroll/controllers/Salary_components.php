<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:18:27
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Salary_components extends MY_Controller {
    public $title = 'Data Salary_components';

    function __construct(){
        parent::__construct();
        $this->load->model('Salary_component_model','salary_component_model');
        $this->model = $this->salary_component_model;
    }
}

