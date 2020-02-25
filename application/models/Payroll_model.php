<?php
/** Generate by crud generator model pada 2020-02-25 09:14:43

*   Author afandi
*/
class Payroll_model extends Base_model{
    protected $_table = 'payrolls';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['employee_id','period_id','take_home_pay','take_home_pay_key'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'period_id'],['data' => 'take_home_pay'],['data' => 'take_home_pay_key']]];

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
			'period_id' => [
				'id' => 'period_id',
				'label' => 'period_id',
				'placeholder' => 'Isikan period_id',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'take_home_pay' => [
				'id' => 'take_home_pay',
				'label' => 'take_home_pay',
				'placeholder' => 'Isikan take_home_pay',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'take_home_pay_key' => [
				'id' => 'take_home_pay_key',
				'label' => 'take_home_pay_key',
				'placeholder' => 'Isikan take_home_pay_key',
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