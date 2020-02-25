<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:19:38
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Skills extends MY_Controller {
    public $title = 'Data Skills';

    function __construct(){
        parent::__construct();
        $this->load->model('Skill_model','skill_model');
        $this->model = $this->skill_model;
    }
}

