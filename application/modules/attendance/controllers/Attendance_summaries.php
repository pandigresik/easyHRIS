<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-02-25 08:29:23
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Attendance_summaries extends MY_Controller {
    public $title = 'Data Attendance_summaries';

    function __construct(){
        parent::__construct();
        $this->load->model('Attendance_summary_model','attendance_summary_model');
        $this->model = $this->attendance_summary_model;
    }
}

