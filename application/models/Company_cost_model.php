<?php
/** Generate by crud generator model pada 2020-02-25 08:46:39

*   Author afandi
*/
class Company_cost_model extends Base_model{
    protected $_table = 'company_costs';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','payroll_id','component_id','benefit_value','benefit_key'];
    protected $headerTableData = [				[['data' => 'payroll_id'],['data' => 'component_id'],['data' => 'benefit_value'],['data' => 'benefit_key']]];

    protected $form = [			
			'payroll_id' => [
				'id' => 'payroll_id',
				'label' => 'payroll_id',
				'placeholder' => 'Isikan payroll_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'component_id' => [
				'id' => 'component_id',
				'label' => 'component_id',
				'placeholder' => 'Isikan component_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'benefit_value' => [
				'id' => 'benefit_value',
				'label' => 'benefit_value',
				'placeholder' => 'Isikan benefit_value',
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