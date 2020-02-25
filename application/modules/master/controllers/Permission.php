<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Permission extends MY_Controller {
    public $title = 'Data Permission';
    private $keyMenu;
    function __construct(){
        parent::__construct();
        $this->load->model('permission_model','permission');
        $this->model = $this->permission;
    }

    public function add($referenceId = NULL){
        $this->actionMethodIndex .= '/'.$referenceId;
        $this->_formEdit(['menus_id' => $referenceId]);
    }

    public function edit(){
        $where = $this->input->post('key');
        $data = $this->model->getEditData($where,FALSE);
        $this->actionMethodIndex .= '/'.$data->menus_id;
        $this->_formEdit($data,$where);
    }

    public function index($referenceId = NULL){
        $this->load->model('menu_model','menus');
        if(empty($referenceId)){
            $key = $this->input->post('key');
            $referenceId = $key['id'];
        }
        $this->setKeyMenu($referenceId);
        $this->actionMethodIndex .= '/'.$referenceId;
        $menu = $this->menus->get($referenceId);
        $this->title .= ' Menu '.$menu->name;
        $this->filters = ['menus_id' => $referenceId];
        parent::index();
    }
    
    public function setTableData(){
		return $this->model->as_array()->fields(array('id','name','route'))->get_many_by($this->filters);
    }
    
    protected function setBtnAdd($key = NULL)
    {
        $key = $this->getKeyMenu();
        return generateAddButton('Tambah', ['onclick' => 'App.addRecord(this)', 'data-url' => site_url($this->pathView.'/add/'.$key)]);
    }

    /**
     * Get the value of keyMenu
     */ 
    public function getKeyMenu()
    {
        return $this->keyMenu;
    }

    /**
     * Set the value of keyMenu
     *
     * @return  self
     */ 
    public function setKeyMenu($keyMenu)
    {
        $this->keyMenu = $keyMenu;
    }
}
