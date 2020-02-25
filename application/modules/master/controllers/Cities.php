<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 05:36:45
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Cities extends MY_Controller {
    public $title = 'Data Kota';    
    function __construct(){
        parent::__construct();
        $this->load->model('City_model','city_model');
        $this->model = $this->city_model;        
        $this->aliasClass = 'Kota';
    }

    public function index($referenceId = null){
        $this->model->setwithRegion(TRUE);
        parent::index($referenceId);
    }
}

