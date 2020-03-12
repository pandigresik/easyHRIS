<?php
/** Generate by crud generator model pada 2020-02-25 09:11:36

*   Author afandi
*/
class Overtime_model extends Base_model{
    protected $_table = 'overtimes';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['overtimes.id','employees.full_name','shiftments.code as shiftment','approvedBy.full_name as approved_by_id','overtime_date','overtimes.start_hour','overtimes.end_hour','raw_value','calculated_value','holiday','description'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'Shift'],['data' => 'Approve Oleh'],['data' => 'Tanggal'],['data' => 'Awal'],['data' => 'Akhir'],['data' => 'Lembur (menit)'],['data' => 'Lembur Dibayar (menit)'],['data' => 'Libur'],['data' => 'Keterangan']]];

    protected $form = [						
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
				'label' => 'Tanggal Lembur',
				'placeholder' => 'Isikan overtime_date',
				            'type' => 'input',
            	'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'start_hour' => [
				'id' => 'start_hour',
				'label' => 'Awal',
				'placeholder' => 'Isikan start_hour',
				'readonly' => 'readonly',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'end_hour' => [
				'id' => 'end_hour',
				'label' => 'Akhir',
				'placeholder' => 'Isikan end_hour',
				'type' => 'input',
				'readonly' => 'readonly',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'raw_value' => [
				'id' => 'raw_value',
				'label' => 'raw_value',
				'placeholder' => 'Isikan raw_value',
				'type' => 'number',
				'readonly' => 'readonly',
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

	public function joinReference(){
		if($this->getWithReferences()){			
			$this->db->join('employees','employees.id = overtimes.employee_id');
			$this->db->join('shiftments','shiftments.id = overtimes.shiftment_id');			
			$this->db->join('employees as approvedBy','approvedBy.id = overtimes.approved_by_id','left');
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