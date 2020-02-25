<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Role_permission extends MY_Controller
{
    public $title = 'Data Permission';
    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_permission_model','role_permissions');
        $this->load->model('role_model','roles');
        $this->load->model('role_menu_model','role_menus');
        $this->load->model('menu_model','menus');
        $this->model = $this->role_permissions;
    }

    public function index($referenceId = null)
    {
        if (empty($referenceId)) {
            $key = $this->input->post('key');
            $referenceId = $key['id'];
        }
        $this->actionMethodIndex .= '/'.$referenceId;
        $roles = $this->roles->get($referenceId);
        $this->title .= ' Role '.$roles->name;
        $this->filters = ['roles_id' => $referenceId];

        $menus = $this->menus->as_array()->with('permissions')->get_many_by(array('status' => 1));
        log_message('error',json_encode($menus));
        $this->db->where($this->filters);
        $rolemenus = $this->role_menus->dropdown('menus_id', 'menus_id');
        $rolePermissions = $this->setTableData();

        $table = $this->load->view('master/role_permission', ['rolePermissions' => $rolePermissions, 'menus' => $menus, 'rolemenus' => $rolemenus, 'form_header' => array('data-actiontype' => 'save', 'data-nexturl' => site_url('master/role'), 'action' => site_url($this->pathView.'/'.$this->actionMethodSave)), 'referenceId' => $referenceId,
                            ], true);
        $data = ['table' => $table, 'title' => $this->title, 'btnAdd' => '&nbsp;'];
        $this->loadView('master/default', $data);
    }

    public function setBtnBack()
    {
        $btnBack = null;
        if (!empty($this->linkBack)) {
            $btnBack = generateDangerButton('Kembali', ['onclick' => 'App.gotoUrl(this)', 'data-url' => site_url($this->linkBack)]);
        }

        return $btnBack;
    }

    public function setTableData()
    {
        $this->db->where($this->filters);
        return $this->model->dropdown('permissions_id', 'permissions_id');
    }

    /** override function parent class */
    public function save()
    {
        $data = $this->input->post('data');
        $where = $this->input->post('key');
        /* set statusnya menjadi non aktif */
        $this->role_permissions->delete_by($where);
        $this->role_menus->delete_by($where);
        //\Model\Storage\Rolepermissions::active()->where($where)->delete();
        //\Model\Storage\Rolemenu::active()->where($where)->delete();
        /** simpan datanya */
        $tmpMenu = [];
        $tmpPermissions = [];
        foreach ($data as $k => $v) {
            $tmpKey = explode('_', $k);
            if ($tmpKey[0] == 'menu') {
                array_push($tmpMenu, array_merge($where, array('menus_id' => $v)));
            } else {
                array_push($tmpPermissions, array_merge($where, array('permissions_id' => $v)));
            }
        }
        if (!empty($tmpMenu)) {
            $this->role_menus->insert_many($tmpMenu);
        }

        if (!empty($tmpPermissions)) {
            $this->role_permissions->insert_many($tmpPermissions);
        }

        $this->result['status'] = 1;
        $this->result['message'] = 'Sudah disimpan';
        $this->display_json($this->result);
    }
}
