<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User extends MY_Controller {
    public $title = 'Data User';
//    protected $withPagination = FALSE;
    function __construct(){
        parent::__construct();
        $this->load->model('user_model','users');
        $this->load->model('role_model','roles');
        $this->model = $this->users;
        
    }

    public function index($referenceId = null){
        $this->model->setWithRole(TRUE);
        parent::index($referenceId);
    }
    /** override function parent class */
    public function save(){
        $data = $this->input->post('data');
		$where = $this->input->post('key');
		if(empty($where)){
            $generatePass = SecurityManager::encode($data['password']);
            $data['password_salt'] = $generatePass['password_salt'];
            $data['password'] = $generatePass['password'];
			$where = [$this->model->getKeyName() => NULL];
        }
        
        $userSaved = $this->model->saveData($where,$data);
        
        $this->result['status'] = 1;
        $this->result['message'] = 'Sudah disimpan';
        
        $this->display_json($this->result);
    }

    protected function setBtnAdd($key = null)
    {
        return generateAddButton('Tambah', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add')])
               . generateAddButton('Import', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url('master/importUser/')])
        ;
    }

    public function setTableConfig()
    {
        parent::setTableConfig();
        $this->table->extra_columns = [
            'btnEdit' => [
                'data' => generatePrimaryButton('<i class="fa fa-pencil"></i>', ['onclick' => 'App.editRecord(this)', 'data-url' => site_url($this->pathView.'/'.$this->actionMethodEdit)])
                    .' '.generateDangerButton('<i class="fa fa-refresh"></i>', ['onclick' => 'App.updateRecord(this)', 'data-urlmessage' => site_url($this->pathView.'/resetMessage'), 'data-url' => site_url($this->pathView.'/resetPassword')])
                    
                ]
            ];
    }

    /** hapus dulu tabel yang berelasi */
    public function delete(){
        $where = $this->input->post('key');
        parent::delete();
    }

    public function searchPaging()
    {
        $this->model->setColumnTableData(['id','ref_nik','role_id']);
        $q = $this->input->post('q');
        $currentPage = $this->input->post('page');
        $limit = $this->model->getPerpage();
        $offset = !empty($currentPage) ? ($currentPage - 1 * $limit)   : 0;
        $where = 'status  = \'A\'';    
        if(is_numeric($q)){
            $where .= ' and ref_nik like \'%'.$q.'%\'';
        }else{
            $where .= ' and name like \'%'.$q.'%\'';
        }
        
        $tmp = $this->paginate($limit, $offset,$where);
        $result = [];
        if(!empty($tmp['data'])){
            $this->result['status'] = 1;
            //$this->result['items'] = $tmp['data'];
            $listUser = array_column($tmp['data'],'ref_nik');
            $usql = convertArr($tmp['data'],'ref_nik');
            $this->load->model('hris/User_hris_model','uhm');
            $uhris = $this->uhm->fields(['NIK','NAMABP','NAMAJABATAN'])->as_array()->get_many_by(['NIK' => $listUser]);
            if(!empty($uhris)){
                foreach($uhris as $us){
                    $nik = $us['NIK'];
                    if(isset($usql[$nik])){
                        array_push($result,['id' => $usql[$nik]['id'].'_'.$usql[$nik]['role_id'],'text' => $us['NAMABP'].' - '.$us['NAMAJABATAN']]);
                    }
                }
            }
            $this->result['items'] = $result;

        }
        
        $this->result['pagination'] = !empty($tmp['data']) ? true : false;
        $this->display_json($this->result);
    }

    protected function defaultFilterPage()
    {
       
    }

    public function resetMessage()
    {
        $where = $this->input->post('key');
        $data = $this->model->get_by($where);                
        echo 'Apakah anda yakin akan mereset password user <strong>('.$data->username.')</strong> ini dengan password <strong>'.$data->username.'</strong> ?';
    }

    public function resetPassword()
    {
        $where = $this->input->post('key');
        $dataUser = $this->model->get_by($where);                
        $generatePass = SecurityManager::encode($dataUser->username);
        $data['password_salt'] = $generatePass['password_salt'];
        $data['password'] = $generatePass['password'];
        if ($this->model->update_by($where,$data)) {
            $this->result['status'] = 1;
            $this->result['message'] = 'Data berhasil diupdate';
        }

        $this->display_json($this->result);
    }

}