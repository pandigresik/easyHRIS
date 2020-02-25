<?php
/** Generate by crud generator model pada 2020-02-25 08:29:23

*   Author afandi
*/
class Attendance_summary_model extends Base_model{
    protected $_table = 'attendance_summaries';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','employee_id','year','month','total_workday','total_in','total_loyality','total_absent','total_overtime'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'Tahun'],['data' => 'Bulan'],['data' => 'Total Hari Kerja'],['data' => 'Total Masuk'],['data' => 'total_loyality'],['data' => 'Total Absent'],['data' => 'Total Overtime']]];

    protected $form = [			
			'id' => [
				'id' => 'id',
				'label' => 'id',
				'placeholder' => 'Isikan id',
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
			'year' => [
				'id' => 'year',
				'label' => 'Tahun',
				'placeholder' => 'Isikan Tahun',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'month' => [
				'id' => 'month',
				'label' => 'Bulan',
				'placeholder' => 'Isikan Bulan',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'total_workday' => [
				'id' => 'total_workday',
				'label' => 'Total Hari Kerja',
				'placeholder' => 'Isikan Total Hari Kerja',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'total_in' => [
				'id' => 'total_in',
				'label' => 'Total Masuk',
				'placeholder' => 'Isikan Total Masuk',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'total_loyality' => [
				'id' => 'total_loyality',
				'label' => 'total_loyality',
				'placeholder' => 'Isikan total_loyality',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'total_absent' => [
				'id' => 'total_absent',
				'label' => 'Total Absent',
				'placeholder' => 'Isikan Total Absent',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'total_overtime' => [
				'id' => 'total_overtime',
				'label' => 'Total Overtime',
				'placeholder' => 'Isikan Total Overtime',
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