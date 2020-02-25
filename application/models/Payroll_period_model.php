<?php
/** Generate by crud generator model pada 2020-02-25 09:13:28

*   Author afandi
*/
class Payroll_period_model extends Base_model{
    protected $_table = 'payroll_periods';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['company_id','year','month','closed'];
    protected $headerTableData = [				[['data' => 'company_id'],['data' => 'year'],['data' => 'month'],['data' => 'closed']]];

    protected $form = [			
			'company_id' => [
				'id' => 'company_id',
				'label' => 'company_id',
				'placeholder' => 'Isikan company_id',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'year' => [
				'id' => 'year',
				'label' => 'year',
				'placeholder' => 'Isikan year',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'month' => [
				'id' => 'month',
				'label' => 'month',
				'placeholder' => 'Isikan month',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'closed' => [
				'id' => 'closed',
				'label' => 'closed',
				'placeholder' => 'Isikan closed',
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