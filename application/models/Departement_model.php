<?php
/** Generate by crud generator model pada 2020-02-25 08:55:17

*   Author afandi
*/
class Departement_model extends Base_model{
    protected $_table = 'departments';
	protected $searchLookupColumn = 'name';    	
    protected $primary_key = 'id';
    protected $columnTableData = ['departments.id','a.name as references','departments.code','departments.name'];
    protected $headerTableData = [				[['data' => 'Reference'],['data' => 'Kode'],['data' => 'Nama']]];

    protected $form = [						
			'parent_id' => [
				'id' => 'parent_id',
				'label' => 'Reference',
				'placeholder' => 'Isikan Reference',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/departements/searchPaging',
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

	public function joinReference(){
		if($this->getWithReferences()){
			$this->db->join('departments a','a.id = departments.parent_id','left');
		}		
	}	
    /** uncomment function ini untuk memberikan nilai default form,
      * misalkan mengisi data pilihan dropdown dari database dll
    protected function setOptionDataForm($where = array()){
        $parentMenu = $this->active()->get(['id','name'])->lists('name','id');
        $parentMenu[0] = 'Menu Utama';
        ksort($parentMenu);
        $this->form['parent_id']['options'] = $parentMenu;
    }
    */
}
?>