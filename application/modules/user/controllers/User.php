<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
/* controller user ini akan digunakan untuk autentikasi dan otorisasi
 * semua controller yang bebas diakses seharusnya mengextends MX_Controller atau CI_Controller
 * */

class User extends MX_Controller
{
    public $userLogin;
    public $permission;
    public $isLogin = false;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('user_model', 'm_user');
        $this->load->library('session');
    }

    public function login()
    {
        $data['appTitle'] = $this->config->item('appTitle');        
        $this->load->view('user/login',$data);
    }

    public function checkLogin()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $result = array(
            'status' => 0,
            'message' => 'Proses login',
            'content' => '',
        );
        $userLogin = $this->m_user->setWithRole(TRUE)->get_by(array('username' => $username));        
        if ($userLogin) {            
            if(SecurityManager::validate($password,$userLogin->password,$userLogin->password_salt)){
                $roleId = !empty($userLogin->role_id) ? $userLogin->role_id : 2;
                $this->setDataLogin($roleId,$userLogin);
                $result['status'] = 1;
            }else{
                $result['message'] = 'Password not match';
            }                        
        }else{
            $result['message'] = 'Username not found';
        }        
        echo json_encode($result);
    }

    private function setDataLogin($roleId, $userLogin, $addtionalInfo = [])
    {
        $this->load->model('menu_model', 'menus');
        $this->load->model('role_menu_model', 'rmm');
        $roleMenu = $this->rmm->as_array()->fields(array('menus_id'))->get_many_by(array('roles_id' => $roleId));

        $menuArr = array_column($roleMenu, 'menus_id');
        $allMenu = $this->menus->with('permissions')->as_array()->get_many_by(array('status' => 1));

        $m = $this->menus->as_array()->with('permissions')->get_many_by(array('id' => $menuArr));
        $accessRoute = $this->getListRoute($m,$roleId);
        $allRoute = $this->getListRoute($allMenu);
        
        $dataUser = array(
            'isLogin' => 1,
            'permission' => serialize($accessRoute),
            'restrictroute' => serialize($allRoute),
            'menuId' => serialize($menuArr),
        );
        $dataUser = array_merge($dataUser, (array) $userLogin);
        if (!empty($addtionalInfo)) {
            $dataUser = array_merge($dataUser, $addtionalInfo);
        }
        $this->session->set_userdata($dataUser);
    }

    private function getListRoute($m,$roleId = NULL)
    {
        $allRoute = [];
        if ($m) {
            if(!empty($roleId)){
                $this->load->model('role_permission_model','rpm');
                $rolePermission = array_column($this->rpm->fields('permissions_id')->as_array()->get_many_by(['roles_id' => $roleId, 'status' => 1]),'permissions_id');
            }
            foreach ($m as $_m) {
                if (!empty($_m['route'])) {
                    array_push($allRoute, $_m['route']);
                    if (!empty($_m['permissions'])) {
                        $routePermission = [];
                        if(!empty($roleId)){
                            foreach($_m['permissions'] as $_tmp){
                                if(in_array($_tmp['id'],$rolePermission)){
                                    array_push($routePermission,$_tmp['route']);
                                }
                            }
                        }else{
                            $routePermission = array_column($_m['permissions'], 'route');
                        }
                        $allRoute = array_merge($allRoute, $routePermission);
                    }
                }
            }
        }

        return $allRoute;
    }
    
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('user/user/login');
    }

    public function isLogin()
    {
        return $this->session->userdata('isLogin');
    }

    public function getUsername()
    {
        return $this->session->userdata('kode_user');
    }

    public function changePassword()
    {
        if (isset($_POST['newPassword'])) {
            $username = $this->getUsername();
            $newPassword = $this->input->post('newPassword');
            $oldPassword = $this->input->post('oldPassword');
            $result = array(
                'status' => 0,
                'message' => '',
            );
            if (!empty($username)) {
                $this->m_user->changePassword($username, $oldPassword, $newPassword);
                if ($this->m_user->affectedRow() > 0) {
                    $result['status'] = 1;
                    $result['message'] = 'Password telah berhasil dirubah.';
                } else {
                    $result['status'] = 0;
                    $result['message'] = 'Password gagal dirubah, password lama mungkin tidak sesuai.';
                }
            } else {
                $result['status'] = 0;
                $result['message'] = 'Login terlebih dahulu. ';
            }
            echo json_encode($result);
        } else {
            $data['nama'] = $this->input->post('nama_user');
            $this->load->view('changePassword', $data);
        }
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setPermission()
    {
    }

    
}
