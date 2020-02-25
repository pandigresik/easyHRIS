<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 09:20:03
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Skill_groups extends MY_Controller {
    public $title = 'Data Skill_groups';

    function __construct(){
        parent::__construct();
        $this->load->model('Skill_group_model','skill_group_model');
        $this->model = $this->skill_group_model;
    }
}

