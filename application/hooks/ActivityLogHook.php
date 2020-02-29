<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
class ActivityLogHook
{
    private $CI;
    public function __construct()
    {
		$this->CI = &get_instance();
		$this->CI->load->library('session');
    }

    public function get_route()
    {
        $module = $this->CI->router->fetch_module();
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $route = $module.'/'.$class.'/'.$method;
        $this->CI->session->set_userdata('current_route', $route);
    }

    public function writeActivity()
    {
        $route = $this->CI->session->userdata('current_route'); /* sudah ada ketika pre-controller */
        $idUser = $this->CI->session->userdata('userId'); /* sudah ada ketika pre-controller */
        $output = $this->CI->output->get_output();
        $params = $this->getParams();
        $method = !empty($route) ? explode('/',$route) : NULL;
        if(empty($method)) return;
        if(empty($idUser)) return;
        $insertMethod = [
            'save','update','approve','reject','delete'
        ];
        if(in_array(end($method),$insertMethod)){
            $this->CI->load->model('activity_log_model');
            $this->CI->activity_log_model->insert(
                ['route' => $route, 'send_data' => json_encode($params), 'comment' => 'activity log', 'created_by' => $idUser]
            );
        }
    }
/*
    public function get_route()
    {
        $module = $this->CI->router->fetch_module();
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $route = $module.'/'.$class.'/'.$method;
        $this->CI->session->set_userdata('current_route', $route);
    }
*/
    private function getParams()
    {
        $result = array();
        if (isset($_POST)) {
            $method = 'POST';
            $result[$method] = $_POST;
            /*foreach($_POST as $_key => $p){

            }*/
        }
        if (isset($_GET)) {
            $method = 'GET';
            $result[$method] = $_GET;
            /*
            foreach($_GET as $_key => $g){

            }*/
        }

        return $result;
    }
}
