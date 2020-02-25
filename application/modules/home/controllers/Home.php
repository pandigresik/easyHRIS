<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Home extends MY_Controller
{
    public $title = '';

    public function __construct(){
        parent::__construct();
        $this->title = $this->config->item('appTitle');
    }
    public function index($referencesId = null)
    {
        $this->load->model('menu_model','menus');
        $menuId = unserialize($this->session->userdata('menuId'));
        $objMenu = $this->menus->get_many_by(array('id' => $menuId));
        
        $data['menu'] = generateMenu($objMenu);
        $data['user'] = unserialize($this->session->userdata('dataUser'));
        $data['waktuAkses'] = convertElemenTglWaktuIndonesia(date('Y-m-d H:i:s'));
        $data['title'] = $this->title;
        $this->load->view('home/home', $data);
    }
}
