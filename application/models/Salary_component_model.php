<?php
/** Generate by crud generator model pada 2020-02-25 09:18:27

*   Author afandi
*/
class Salary_component_model extends Base_model{
    protected $_table = 'salary_components';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['code','name','state','fixed'];
    protected $headerTableData = [				[['data' => 'code'],['data' => 'name'],['data' => 'state'],['data' => 'fixed']]];

    protected $form = [			
			'code' => [
				'id' => 'code',
				'label' => 'code',
				'placeholder' => 'Isikan code',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'name' => [
				'id' => 'name',
				'label' => 'name',
				'placeholder' => 'Isikan name',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'state' => [
				'id' => 'state',
				'label' => 'state',
				'placeholder' => 'Isikan state',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'fixed' => [
				'id' => 'fixed',
				'label' => 'fixed',
				'placeholder' => 'Isikan fixed',
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