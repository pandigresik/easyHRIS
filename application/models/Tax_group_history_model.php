<?php
/** Generate by crud generator model pada 2020-02-25 09:20:36

*   Author afandi
*/
class Tax_group_history_model extends Base_model{
    protected $_table = 'tax_group_history';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['employee_id','old_tax_group','new_tax_group','old_risk_ratio','new_risk_ratio'];
    protected $headerTableData = [				[['data' => 'employee_id'],['data' => 'old_tax_group'],['data' => 'new_tax_group'],['data' => 'old_risk_ratio'],['data' => 'new_risk_ratio']]];

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
			'old_tax_group' => [
				'id' => 'old_tax_group',
				'label' => 'old_tax_group',
				'placeholder' => 'Isikan old_tax_group',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_tax_group' => [
				'id' => 'new_tax_group',
				'label' => 'new_tax_group',
				'placeholder' => 'Isikan new_tax_group',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'old_risk_ratio' => [
				'id' => 'old_risk_ratio',
				'label' => 'old_risk_ratio',
				'placeholder' => 'Isikan old_risk_ratio',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_risk_ratio' => [
				'id' => 'new_risk_ratio',
				'label' => 'new_risk_ratio',
				'placeholder' => 'Isikan new_risk_ratio',
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