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

class Auth extends REST_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->helper(array('authorization','jwt'));
        $this->load->model('user/m_user');
    }
    /**
     * URL: http://localhost/CodeIgniter-JWT-Sample/auth/token
     * Method: GET
     */
    public function token_post()
    {   
        $username = $this->post('username');
        $password = $this->post('password');
        $tokenData = array();
        $output = array('status' => 0, 'content' => '', 'message' => '');
        $user = $this->m_user->login($username,$password)->first();
        if(!empty($user)){
            $tokenData['kode_user'] = $user['id_user'];        
            $tokenData['level_user'] = $user['user_role'];
            $tokenData['kode_farm'] = $user['id_pegawai'];           
            $output['content'] = AUTHORIZATION::generateToken($tokenData); 
            $output['status'] = 1;
        }else{
            $output['message'] = 'Username atau password salah';
        }                
        $this->response($output, 200);
    }

    public function tokenSCF_post()
    {   
        $username = $this->post('username');
        $password = $this->post('password');
        
        $tokenData = array();
        $output = array('status' => 0, 'content' => '', 'message' => '');
        $user = $this->m_user->login($username,$password)->first();
        if(!empty($user)){
            $tokenData['kode_user'] = $user['id_user'];        
            $tokenData['level_user'] = $user['user_role'];
            $tokenData['kode_farm'] = $user['id_pegawai'];   
            // 2015 kode untuk role DEV, nanti diganti untuk role security   
            if($tokenData['level_user'] == '3014'){
                $output['content'] = AUTHORIZATION::generateToken($tokenData); 
                $output['status'] = 1;
            }else{
                $output['message'] = 'Anda bukan security';    
            }            
        }else{
            $output['message'] = 'Username atau password salah';
        }                
        $this->response($output, 200);
    }


    
}