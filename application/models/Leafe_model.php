<?php
/** Generate by crud generator model pada 2020-02-25 09:08:25

*   Author afandi
*/
class Leafe_model extends Base_model{
    protected $_table = 'leaves';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['employee_id','reason_id','leave_date','amount','description'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'reason_id'],['data' => 'leave_date'],['data' => 'amount'],['data' => 'description']]];

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
			'reason_id' => [
				'id' => 'reason_id',
				'label' => 'reason_id',
				'placeholder' => 'Isikan reason_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'leave_date' => [
				'id' => 'leave_date',
				'label' => 'leave_date',
				'placeholder' => 'Isikan leave_date',
				'type' => 'input',
            	'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'amount' => [
				'id' => 'amount',
				'label' => 'amount',
				'placeholder' => 'Isikan amount',
				'type' => 'number',
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