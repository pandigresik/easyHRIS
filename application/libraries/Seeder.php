<?php
/**
 * 『CodeIgniter徹底入門』のサンプルアプリケーションをCodeIgniter 3.0にアップデート
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    BSD 3-Clause License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/codeigniter-tettei-apps
 */

class Seeder
{
	private $CI;
	private $db;	
	protected $dbforge;
	protected $objModel = 'object_model';
	protected $model;
	public function __construct()
	{
		$this->CI =& get_instance();						
		$this->db = $this->CI->load->database('default_cli',TRUE);			
	}

	/**
	 * Run another seeder
	 * 
	 * @param string $seeder Seeder classname
	 */
	public function call($seeder)
	{
		$file = APPPATH . 'database/seeds/' . $seeder . '.php';
		require_once $file;
		$obj = new $seeder;
		$obj->setModel();
		$obj->run();
	}
	
	public function setModel(){
		$this->CI->load->model($this->objModel,'om');			
		$this->model = $this->CI->om;
		$this->model->set_database($this->db);
	}

	public function __get($property)
	{
		return $this->CI->$property;
	}
}
