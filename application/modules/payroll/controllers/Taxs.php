<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:21:22
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Taxs extends MY_Controller {
    public $title = 'Data Taxs';

    function __construct(){
        parent::__construct();
        $this->load->model('Tax_model','tax_model');
        $this->model = $this->tax_model;
    }
}

