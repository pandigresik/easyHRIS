<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cfinger extends Client_Controller{
	protected $model;
	private $limitSinkron = 10;
	public function __construct(){
		parent::__construct();
		$this->model = new \Model\Storage\Fingertime();
	}

	public function sinkron(){
		/* $idSinkronisasi didapat dari id di server utama */
		$result = array('status' => 0, 'message' => 'proses upload data gagal');
		$asal = $this->config->item('source');
		$lanjut  = 1;
		while($lanjut){
			$idSinkronisasi = $this->rest->get('attendance/api/finger/lastIdSinkronCenter/',array('source'=>$asal));
			if(!$idSinkronisasi){
				$result['message'] = 'Koneksi ke server gagal';
				return $result;
			}
			$idSinkron = is_null($idSinkronisasi->content) ? 0 : $idSinkronisasi->content;
			$data_kirim = $this->getDataUpload($idSinkron);
			if(!empty($data_kirim)){
				$kirim = $this->rest->post('attendance/api/finger/sinkron/',array('data'=>$data_kirim));
				$result['status'] = $kirim->status;
				$result['message'] = $kirim->message;
				/** data yang pernah dikirim ke server */
				$dataSinkron = [
					'tableData' => 'fingertime',
					'sendData' => json_encode($data_kirim)
				];
				\Model\Storage\Logsinkronisasi::insert($dataSinkron);
				
			}else{
				$result['message'] = 'Tidak ada data yang harus diupload';
				$lanjut = 0;
			}
			if(!$result['status']){
				$lanjut = 0;
			}
		}
		return $result;
	}

	/* dapatkan semua data yang akan diupload ke server sinkron */
	private function getDataUpload($idTelahSinkron){
		$result = array();
		$asal = $this->config->item('source');
		if(!is_null($idTelahSinkron)){
			$result = $this->model->select(['uid','serial_number','function_key','fingerdate','fingertime','fingerdatetime','id as ref_id'])
					->selectRaw("'".$asal."' as source")
					->where('id','>',$idTelahSinkron)
					->limit($this->limitSinkron)
					->get()
					->toArray();
		}
		return $result;
	}

	private function removeEmpty($arr){
		$tmp = array();
		if(!empty($arr)){
			foreach($arr as $r){
				array_push($tmp,array_filter($r,function($var){
						return !is_null($var);
					}
				));
			}
		}		
		return $tmp;
	}

	private function isMultiDimensional($myarray){
		$result = 1;
		if (count($myarray) == count($myarray, COUNT_RECURSIVE)){
			$result = 0;
		}
		return $result;
	}
}
