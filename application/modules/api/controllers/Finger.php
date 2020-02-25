<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Changes:
 * 1. This project contains .htaccess file for windows machine.
 *    Please update as per your requirements.
 *    Samples (Win/Linux): http://stackoverflow.com/questions/28525870/removing-index-php-from-url-in-codeigniter-on-mandriva
 *
 * 2. Change 'encryption_key' in application\config\config.php
 *    Link for encryption_key: http://jeffreybarke.net/tools/codeigniter-encryption-key-generator/
 * 
 * 3. Change 'jwt_key' in application\config\jwt.php
 *
 */

//class Finger extends RESTSECURE_Controller
class Finger extends REST_Controller
{

    public function __construct(){
        parent::__construct();
    }
      
    public function lastIdSinkronCenter_get()
    {   
        $headers = $this->input->request_headers();               
        $output = array('status' => 0,'content' => '','message' => 'Data tidak ditemukan');
        $source = $this->get('source');      
        $idSinkron = \Model\Storage\Fingertime::whereSource($source)->max('ref_id');          
        
        $output['status'] = 1;
        $output['content'] = $idSinkron;
        $this->response($output, 200);
    }


    public function sinkron_post()
    {   
        $output = array('status' => 0,'content' => '','message' => 'Data tidak ditemukan');
        $data = $this->post('data');              
        if(\Model\Storage\Fingertime::insert($data)){
            $output['status'] = 1;
        }
        $this->response($output, 200);
    }
}