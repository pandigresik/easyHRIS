<?php
/** Generate by crud generator model pada 2020-02-28 05:23:11
*   Author afandi
*/
class Salary_group_model extends Base_model{
    protected $_table = 'salary_groups';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','code','name'];
    protected $headerTableData = [				[['data' => 'Kode'],['data' => 'Nama']]];

    protected $form = [			
			'code' => [
				'id' => 'code',
				'label' => 'Kode',
				'placeholder' => 'Isikan code',
				'type' => 'input',
                'value' => '',	
                'maxLength' => 7,
                'required' => 'required'
			]	,			
			'name' => [
				'id' => 'name',
				'label' => 'Nama',
				'placeholder' => 'Isikan nama',
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