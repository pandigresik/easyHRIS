<?php
/** Generate by crud generator model pada 2020-02-25 08:22:55

*   Author afandi
*/
class Attendance_model extends Base_model{
    protected $_table = 'attendances';
	protected $defaultOrderColumn = ['employee_id' => 'asc','attendance_date'=> 'asc'];	
    protected $primary_key = 'id';
    protected $columnTableData = ['attendances.id','employees.full_name','shiftments.code as shiftment','reason_id','attendance_date','description','shift_checkin','shift_checkout','check_in','early_in','late_in','check_out','early_out','late_out','absent'];
    protected $headerTableData = [				[['data' => 'Nama'],['data' => 'Shift'],['data' => 'Alasan'],['data' => 'Tanggal'],['data' => 'keterangan'],['data' => 'Jam Masuk'],['data' => 'Jam Pulang'],['data' => 'Masuk'],['data' => 'Datang Awal (menit)'],['data' => 'Terlambat Awal (menit)'],['data' => 'Pulang'],['data' => 'Pulang Cepat (menit)'],['data' => 'Pulang Akhir (menit)'],['data' => 'absent']]];

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
			'shiftment_id' => [
				'id' => 'shiftment_id',
				'label' => 'shiftment_id',
				'placeholder' => 'Isikan shiftment_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'reason_id' => [
				'id' => 'reason_id',
				'label' => 'reason_id',
				'placeholder' => 'Isikan reason_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'attendance_date' => [
				'id' => 'attendance_date',
				'label' => 'attendance_date',
				'placeholder' => 'Isikan attendance_date',
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
			'check_in' => [
				'id' => 'check_in',
				'label' => 'check_in',
				'placeholder' => 'Isikan check_in',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'check_out' => [
				'id' => 'check_out',
				'label' => 'check_out',
				'placeholder' => 'Isikan check_out',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'early_in' => [
				'id' => 'early_in',
				'label' => 'early_in',
				'placeholder' => 'Isikan early_in',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'early_out' => [
				'id' => 'early_out',
				'label' => 'early_out',
				'placeholder' => 'Isikan early_out',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'late_in' => [
				'id' => 'late_in',
				'label' => 'late_in',
				'placeholder' => 'Isikan late_in',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'late_out' => [
				'id' => 'late_out',
				'label' => 'late_out',
				'placeholder' => 'Isikan late_out',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'absent' => [
				'id' => 'absent',
				'label' => 'absent',
				'placeholder' => 'Isikan absent',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,
		'submit' => [
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan'
        ]];
	public function joinReference(){
		if($this->getWithReferences()){			
			$this->db->join('employees','employees.id = attendances.employee_id');
			$this->db->join('shiftments','shiftments.id = attendances.shiftment_id');			
		}
	}		
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