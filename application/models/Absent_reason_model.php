<?php
/** Generate by crud generator model pada 2020-02-25 08:26:34

*   Author afandi
*/
class Absent_reason_model extends Base_model{
    protected $_table = 'absent_reasons';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','type','code','name'];
    protected $headerTableData = [				[['data' => 'type'],['data' => 'Kode'],['data' => 'Nama']]];

    protected $form = [			
			'id' => [
				'id' => 'id',
				'label' => 'id',
				'placeholder' => 'Isikan id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'type' => [
				'id' => 'type',
				'label' => 'type',
				'placeholder' => 'Isikan type',
				'type' => 'input',
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
}
?>