<?php
/** Generate by crud generator model pada 2020-02-25 11:12:34
*   Menggunakan ORM eloquent
*   Author afandi
*/
class Tax_model extends MY_Model{
    protected $_table = 'taxs';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['period_id','employee_id','tax_group','untaxable','taxable','tax_value','tax_key'];
    protected $headerTableData = [				[['data' => 'period_id'],['data' => 'employee_id'],['data' => 'tax_group'],['data' => 'untaxable'],['data' => 'taxable'],['data' => 'tax_value'],['data' => 'tax_key']]];

    protected $form = [			
			'period_id' => [
				'id' => 'period_id',
				'label' => 'period_id',
				'placeholder' => 'Isikan period_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
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
			'tax_group' => [
				'id' => 'tax_group',
				'label' => 'tax_group',
				'placeholder' => 'Isikan tax_group',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'untaxable' => [
				'id' => 'untaxable',
				'label' => 'untaxable',
				'placeholder' => 'Isikan untaxable',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'taxable' => [
				'id' => 'taxable',
				'label' => 'taxable',
				'placeholder' => 'Isikan taxable',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'tax_value' => [
				'id' => 'tax_value',
				'label' => 'tax_value',
				'placeholder' => 'Isikan tax_value',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'tax_key' => [
				'id' => 'tax_key',
				'label' => 'tax_key',
				'placeholder' => 'Isikan tax_key',
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