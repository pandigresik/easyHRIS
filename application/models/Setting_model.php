<?php
/** Generate by crud generator model pada 2020-02-25 11:09:36
*   Menggunakan ORM eloquent
*   Author afandi
*/
class Setting_model extends MY_Model{
    protected $_table = 'settings';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['name','type','value'];
    protected $headerTableData = [				[['data' => 'name'],['data' => 'type'],['data' => 'value']]];

    protected $form = [			
			'name' => [
				'id' => 'name',
				'label' => 'name',
				'placeholder' => 'Isikan name',
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
			'value' => [
				'id' => 'value',
				'label' => 'value',
				'placeholder' => 'Isikan value',
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