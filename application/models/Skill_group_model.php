<?php
/** Generate by crud generator model pada 2020-02-25 09:20:03

*   Author afandi
*/
class Skill_group_model extends Base_model{
    protected $_table = 'skill_groups';    
    protected $primary_key = 'id';
    protected $columnTableData = ['parent_id','name'];
    protected $headerTableData = [				[['data' => 'parent_id'],['data' => 'name']]];

    protected $form = [			
			'parent_id' => [
				'id' => 'parent_id',
				'label' => 'parent_id',
				'placeholder' => 'Isikan parent_id',
                'type' => 'dropdown',
				'class' => 'select2_ajax',
				'data-url' => 'master/skill_groups/searchPaging',
                'options' => [''],
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