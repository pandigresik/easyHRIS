<?php
/** Generate by crud generator model pada 2020-02-25 05:35:22

*   Author afandi
*/
class Company_department_model extends Base_model{
    protected $_table = 'cities';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','department_id','company_id','created_by','updated_by','deleted_at','created_at','updated_at'];
    protected $headerTableData = [				[['data' => 'department_id'],['data' => 'company_id'],['data' => 'created_by'],['data' => 'updated_by'],['data' => 'deleted_at'],['data' => 'created_at'],['data' => 'updated_at']]];

    protected $form = [			
			'id' => [
				'id' => 'id',
				'label' => 'id',
				'placeholder' => 'Isikan id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'department_id' => [
				'id' => 'department_id',
				'label' => 'department_id',
				'placeholder' => 'Isikan department_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'company_id' => [
				'id' => 'company_id',
				'label' => 'company_id',
				'placeholder' => 'Isikan company_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'created_by' => [
				'id' => 'created_by',
				'label' => 'created_by',
				'placeholder' => 'Isikan created_by',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'updated_by' => [
				'id' => 'updated_by',
				'label' => 'updated_by',
				'placeholder' => 'Isikan updated_by',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'deleted_at' => [
				'id' => 'deleted_at',
				'label' => 'deleted_at',
				'placeholder' => 'Isikan deleted_at',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'created_at' => [
				'id' => 'created_at',
				'label' => 'created_at',
				'placeholder' => 'Isikan created_at',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'updated_at' => [
				'id' => 'updated_at',
				'label' => 'updated_at',
				'placeholder' => 'Isikan updated_at',
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