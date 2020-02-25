<?php
/** Generate by crud generator model pada 2020-02-25 09:19:04

*   Author afandi
*/
class Shiftment_model extends Base_model{
    protected $_table = 'shiftments';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['code','name','start_hour','end_hour'];
    protected $headerTableData = [				[['data' => 'code'],['data' => 'name'],['data' => 'start_hour'],['data' => 'end_hour']]];

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
			'start_hour' => [
				'id' => 'start_hour',
				'label' => 'start_hour',
				'placeholder' => 'Isikan start_hour',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'end_hour' => [
				'id' => 'end_hour',
				'label' => 'end_hour',
				'placeholder' => 'Isikan end_hour',
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