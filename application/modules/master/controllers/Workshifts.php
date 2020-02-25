<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:22:12
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Workshifts extends MY_Controller {
    public $title = 'Data Workshifts';

    function __construct(){
        parent::__construct();
        $this->load->model('Workshift_model','workshift_model');
        $this->model = $this->workshift_model;
    }
}

