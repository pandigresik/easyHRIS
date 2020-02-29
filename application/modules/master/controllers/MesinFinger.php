<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class MesinFinger extends MY_Controller
{
    public $title = 'Data Mesin Finger';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('mesin_finger_model','mesin');
        $this->model = $this->mesin;
    }
}
