<?php
/** Generate by crud generator model pada 2020-02-25 09:11:36

*   Author afandi
*/
class Overtime_model extends Base_model{
    protected $_table = 'overtimes';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['employee_id','shiftment_id','approved_by_id','overtime_date','start_hour','end_hour','raw_value','calculated_value','holiday','overday','description'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'Shift'],['data' => 'Approve Oleh'],['data' => 'overtime_date'],['data' => 'start_hour'],['data' => 'end_hour'],['data' => 'raw_value'],['data' => 'calculated_value'],['data' => 'holiday'],['data' => 'overday'],['data' => 'description']]];

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
			'shiftment_id' => [
				'id' => 'shiftment_id',
				'label' => 'Shift',
				'placeholder' => 'Isikan Shift',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'approved_by_id' => [
				'id' => 'approved_by_id',
				'label' => 'Approve Oleh',
				'placeholder' => 'Isikan Approve Oleh',
				'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'overtime_date' => [
				'id' => 'overtime_date',
				'label' => 'overtime_date',
				'placeholder' => 'Isikan overtime_date',
				            'type' => 'input',
            'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'start_hour' => [
				'id' => 'start_hour',
				'label' => 'start_hour',
				'placeholder' => 'Isikan start_hour',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'end_hour' => [
				'id' => 'end_hour',
				'label' => 'end_hour',
				'placeholder' => 'Isikan end_hour',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'raw_value' => [
				'id' => 'raw_value',
				'label' => 'raw_value',
				'placeholder' => 'Isikan raw_value',
				'type' => 'number',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'calculated_value' => [
				'id' => 'calculated_value',
				'label' => 'calculated_value',
				'placeholder' => 'Isikan calculated_value',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'holiday' => [
				'id' => 'holiday',
				'label' => 'holiday',
				'placeholder' => 'Isikan holiday',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'overday' => [
				'id' => 'overday',
				'label' => 'overday',
				'placeholder' => 'Isikan overday',
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