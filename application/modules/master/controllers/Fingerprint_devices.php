<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Generate by crud generator model pada 2020-03-05 05:29:55
*   method index, add, edit, delete, detail dapat dioverride jika ingin melakukan custom pada controller tertentu
*   Author afandi
*/
class Fingerprint_devices extends MY_Controller {
    public $title = 'Data Fingerprint_devices';

    function __construct(){
        parent::__construct();
        $this->load->model('Fingerprint_device_model','fingerprint_device_model');
        $this->model = $this->fingerprint_device_model;
    }
}

