<?php
/** Generate by crud generator model pada 2020-02-25 09:22:12

*   Author afandi
*/
class Workshift_model extends Base_model{
    protected $_table = 'workshifts';
	private $withShiftment = FALSE;	
	protected $before_get = array('joinReference','joinShiftment');  
    protected $primary_key = 'id';
    protected $columnTableData = ['employees.full_name','employees.code as nip','shiftments.code as shiftment','workshifts.description as description','work_date'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'NIP'],['data' => 'Shift'],['data' => 'Keterangan'],['data' => 'Tanggal']]];

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
				'placeholder' => 'Isikan shift',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/shiftments/searchPaging',
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
			'work_date' => [
				'id' => 'work_date',
				'label' => 'Tanggal',
				'placeholder' => 'Isikan tanggal',
				'type' => 'input',
            	'data-tipe' => 'date',
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
			$this->db->join('employees','employees.id = workshifts.employee_id');
			$this->db->join('shiftments','shiftments.id = workshifts.shiftment_id');			
		}
	}

	public function joinShiftment(){
		if($this->getWithShiftment()){			
			$this->db->join('shiftments','shiftments.id = workshifts.shiftment_id');			
		}
	}		
	
	public function overDayEmployeeFinger(){		
		$this->db->join('shiftments','shiftments.id = workshifts.shiftment_id and shiftments.end_hour < shiftments.start_hour');					
		$this->db->join('attendance_logfingers',"attendance_logfingers.employee_id = workshifts.employee_id and attendance_logfingers.fingertime >= date_sub(concat(DATE_FORMAT(date_add(workshifts.work_date,interval 1 DAY) , '%Y-%m-%d'),' ',shiftments.end_hour), INTERVAL 2 HOUR) and attendance_logfingers.fingertime <= date_add(concat(DATE_FORMAT(date_add(workshifts.work_date,interval 1 DAY) , '%Y-%m-%d'),' ',shiftments.end_hour), INTERVAL 4 HOUR)");							
		return $this;
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

	/**
	 * Get the value of withShiftment
	 */ 
	public function getWithShiftment()
	{
		return $this->withShiftment;
	}

	/**
	 * Set the value of withShiftment
	 *
	 * @return  self
	 */ 
	public function setWithShiftment($withShiftment)
	{
		$this->withShiftment = $withShiftment;

		return $this;
	}
}
?>