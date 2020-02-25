<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class Role_menu extends MY_Controller
{
    public $title = 'Data Role / Peran';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('role_menu_model','role_menu');
        $this->model = $this->role_menu;
    }
}
