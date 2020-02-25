<?php
/** Generate by crud generator model pada 2020-02-25 05:36:45

*   Author afandi
*/
class City_model extends Base_model{
    protected $_table = 'cities';
	private $withRegion = FALSE;
    protected $before_get = array('joinRegion');    
    protected $primary_key = 'id';
    protected $columnTableData = ['cities.id','regions.name as wilayah','cities.code','cities.name'];
    protected $headerTableData = [				[['data' => 'Wilayah'],['data' => 'Kode'],['data' => 'Nama']]];

    protected $form = [						
			'region_id' => [
				'id' => 'region_id',
				'label' => 'Wilayah',
				'placeholder' => 'Isikan Wilayah',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/regions/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'code' => [
				'id' => 'code',
				'label' => 'Kode',
				'placeholder' => 'Isikan Kode',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'name' => [
				'id' => 'name',
				'label' => 'Nama',
				'placeholder' => 'Isikan Nama',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,
		'submit' => [
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan'
        ]];

    /** uncomment function ini untuk memberikan nilai default form,
      * misalkan mengisi data pilihan dropdown dari database dll
    protected function setOptionDataForm($where = array()){
        $parentMenu = $this->active()->get(['id','name'])->lists('name','id');
        $parentMenu[0] = 'Menu Utama';
        ksort($parentMenu);
        $this->form['parent_id']['options'] = $parentMenu;
    }
    */
	public function joinRegion(){
		if($this->getWithRegion()){
			$this->db->join('regions','regions.id = cities.region_id');
		}
	}
	/**
	 * Get the value of withRegion
	 */ 
	public function getWithRegion()
	{
		return $this->withRegion;
	}

	/**
	 * Set the value of withRegion
	 *
	 * @return  self
	 */ 
	public function setWithRegion($withRegion)
	{
		$this->withRegion = $withRegion;

		return $this;
	}
}
?>