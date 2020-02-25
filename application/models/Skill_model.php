<?php
/** Generate by crud generator model pada 2020-02-25 09:19:38

*   Author afandi
*/
class Skill_model extends Base_model{
    protected $_table = 'skills';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['skill_group_id','name'];
    protected $headerTableData = [				[['data' => 'skill_group_id'],['data' => 'name']]];

    protected $form = [			
			'skill_group_id' => [
				'id' => 'skill_group_id',
				'label' => 'skill_group_id',
				'placeholder' => 'Isikan skill_group_id',
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