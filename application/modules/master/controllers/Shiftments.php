<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:19:04
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Shiftments extends MY_Controller {
    public $title = 'Data Shiftments';

    function __construct(){
        parent::__construct();
        $this->load->model('Shiftment_model','shiftment_model');
        $this->model = $this->shiftment_model;
    }
}

