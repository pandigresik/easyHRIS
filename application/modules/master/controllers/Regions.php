<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 05:39:17
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Regions extends MY_Controller {
    public $title = 'Data Regions';

    function __construct(){
        parent::__construct();
        $this->load->model('Region_model','region_model');
        $this->model = $this->region_model;
    }
}

