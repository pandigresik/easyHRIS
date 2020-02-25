<?php
/** Generate by crud generator model pada 2020-02-25 09:17:01

*   Author afandi
*/
class Salary_benefit_history_model extends Base_model{
    protected $_table = 'salary_benefit_histories';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['employee_id','component_id','contract_id','new_benefit_value','old_benefit_value','benefit_key','description'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'component_id'],['data' => 'contract_id'],['data' => 'new_benefit_value'],['data' => 'old_benefit_value'],['data' => 'benefit_key'],['data' => 'description']]];

    protected $form = [			
			'employee_id' => [
				'id' => 'employee_id',
				'label' => 'Pegawai',
				'placeholder' => 'Isikan Pegawai',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'component_id' => [
				'id' => 'component_id',
				'label' => 'component_id',
				'placeholder' => 'Isikan component_id',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'contract_id' => [
				'id' => 'contract_id',
				'label' => 'contract_id',
				'placeholder' => 'Isikan contract_id',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_benefit_value' => [
				'id' => 'new_benefit_value',
				'label' => 'new_benefit_value',
				'placeholder' => 'Isikan new_benefit_value',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'old_benefit_value' => [
				'id' => 'old_benefit_value',
				'label' => 'old_benefit_value',
				'placeholder' => 'Isikan old_benefit_value',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'benefit_key' => [
				'id' => 'benefit_key',
				'label' => 'benefit_key',
				'placeholder' => 'Isikan benefit_key',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'description' => [
				'id' => 'description',
				'label' => 'description',
				'placeholder' => 'Isikan description',
				'type' => 'textarea',
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