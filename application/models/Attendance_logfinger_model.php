<?php
/** Generate by crud generator model pada 2020-03-05 05:27:05
*   Author afandi
*/
class Attendance_logfinger_model extends Base_model{
    protected $_table = 'attendance_logfingers';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','employee_id','type_absen','fingertime','fingerprint_device_id'];
    protected $headerTableData = [				[['data' => 'employee_id'],['data' => 'type_absen'],['data' => 'fingertime'],['data' => 'fingerprint_device_id']]];

    protected $form = [			
			'id' => [
				'id' => 'id',
				'label' => 'id',
				'placeholder' => 'Isikan id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
		/*	'employee_id' => [
				'id' => 'employee_id',
				'label' => 'employee_id',
				'placeholder' => 'Isikan employee_id',
				'type' => 'dropdown',
				'value' => '',	
				'required' => 'required'	
			]	,
			'type_absen' => [
				'id' => 'type_absen',
				'label' => 'type_absen',
				'placeholder' => 'Isikan type_absen',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,
			'fingertime' => [
				'id' => 'fingertime',
				'label' => 'fingertime',
				'placeholder' => 'Isikan fingertime',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,
			'fingerprint_device_id' => [
				'id' => 'fingerprint_device_id',
				'label' => 'fingerprint_device_id',
				'placeholder' => 'Isikan fingerprint_device_id',
				'type' => 'dropdown',
				'value' => '',	
				'required' => 'required'	
			]	,
		*/	
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