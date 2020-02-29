<?php
/** Generate by crud generator model pada 2020-02-25 09:00:04
*   Author afandi
*/
class Employee_model extends Base_model{	
	protected $_table = 'employees';
	protected $searchLookupColumn = 'full_name';    	
	protected $primary_key = 'id';
	protected $before_create = array('created_at','updated_at','generate_uuid','setting_data');    
    protected $before_update = array('updated_at','setting_data');    
    protected $columnTableData = ['employees.id','contracts.letter_number','job_titles.name as jobtitle','emp.full_name as supervisor','employees.code','employees.full_name','employees.email','employees.tax_group','salary_groups.name','shiftment_groups.name as shiftment'];
    protected $headerTableData = [[['data' => 'Nomer Kontrak'],['data' => 'Jabatan'],['data' => 'Atasan'],['data' => 'NIP'],['data' => 'Nama'],['data' => 'Email'],['data' => 'Pajak'],['data' => 'Kode Gaji'],['data' => 'Kode Shift']]];

    protected $form = [									
			'code' => [
				'id' => 'code',
				'label' => 'NIP',
				'placeholder' => 'Isikan code',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'full_name' => [
				'id' => 'full_name',
				'label' => 'Nama karyawan',
				'placeholder' => 'Isikan full_name',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'gender' => [
				'id' => 'gender',
				'label' => 'Jenis Kelamin',
				'placeholder' => 'Isikan gender',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['M' => 'Pria','F' => 'Wanita'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'date_of_birth' => [
				'id' => 'date_of_birth',
				'label' => 'Tanggal lahir',
				'placeholder' => 'Isikan date_of_birth',
				'type' => 'input',
				'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'identity_number' => [
				'id' => 'identity_number',
				'label' => 'Nomer identitas',
				'placeholder' => 'Isikan identity_number',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'identity_type' => [
				'id' => 'identity_type',
				'label' => 'Jenis Identitas',
				'placeholder' => 'Isikan identity_type',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['KTP' => 'KTP','SIM' => 'SIM','PASSPOR' => 'Passpor'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'marital_status' => [
				'id' => 'marital_status',
				'label' => 'Status pernikahan',
				'placeholder' => 'Isikan marital_status',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['M' => 'Menikah', 'BM' => 'Belum Menikah', 'TM' => 'Duda / Janda'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'email' => [
				'id' => 'email',
				'label' => 'Email',
				'placeholder' => 'Isikan email',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			],
			'region_of_birth_id' => [
				'id' => 'region_of_birth_id',
				'label' => 'Tempat lahir',
				'placeholder' => 'Isikan provinsi',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/regions/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'city_of_birth_id' => [
				'id' => 'city_of_birth_id',
				'label' => 'Kota lahir',
				'placeholder' => 'Isikan kota',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/cities/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'address' => [
				'id' => 'address',
				'label' => 'Alamat',
				'placeholder' => 'Isikan alamat',
				'type' => 'input',
				'value' => '',					
			]	,			
			'join_date' => [
				'id' => 'join_date',
				'label' => 'Tanggal Masuk',
				'placeholder' => 'Isikan tanggal masuk',
				'type' => 'input',
				'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,
			'contract_id' => [
				'id' => 'contract_id',
				'label' => 'Nomer Kontrak',
				'placeholder' => 'Isikan nomer kontrak',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/contracts/searchPaging',
				'value' => '',					
			]	,			
			'company_id' => [
				'id' => 'company_id',
				'label' => 'Perusahaan',
				'placeholder' => 'Isikan perusahaan',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => [''],				
				'value' => '',	
				'required' => 'required'	
			],			
			'department_id' => [
				'id' => 'department_id',
				'label' => 'Department',
				'placeholder' => 'Isikan department',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => [''],				
				'value' => '',	
				'required' => 'required'	
			]	,						
			'jobtitle_id' => [
				'id' => 'jobtitle_id',
				'label' => 'Jabatan',
				'placeholder' => 'Isikan jobtitle_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/job_titles/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'supervisor_id' => [
				'id' => 'supervisor_id',
				'label' => 'Atasan',
				'placeholder' => 'Isikan Atasan',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,						
			'employee_status' => [
				'id' => 'employee_status',
				'label' => 'Status Karyawan',
				'placeholder' => 'Isikan employee_status',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['K' => 'Kontrak', 'T' => 'Tetap'],				
				'value' => '',	
				'required' => 'required'	
			]	,															
			'tax_group' => [
				'id' => 'tax_group',
				'label' => 'Pajak',
				'placeholder' => 'Isikan tax_group',
				'type' => 'dropdown',
				'options' => ['TK' => 'Tidak Kawin','K0' => 'Kawin tanpa anak','K1' => 'Kawin anak 1','K2' => 'Kawin anak 2'],
				'class' => 'select2_single',
				'value' => '',	
				'required' => 'required'	
			]	,
			'salary_group_id' => [
				'id' => 'salary_group_id',
				'label' => 'Grup gaji',
				'placeholder' => 'Isikan tax_group',
				'type' => 'dropdown',
				'options' => [''],
				'class' => 'select2_single',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'shiftment_group_id' => [
				'id' => 'shiftment_group_id',
				'label' => 'Grup shift',
				'placeholder' => 'Isikan group shift',
				'type' => 'dropdown',
				'options' => [''],
				'class' => 'select2_single',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'resign_date' => [
				'id' => 'resign_date',
				'label' => 'Tanggal keluar',
				'placeholder' => 'Isikan resign_date',
				'type' => 'input',
				'data-tipe' => 'date',
				'value' => '',	
				
			]	,			
			'have_overtime_benefit' => [
				'id' => 'have_overtime_benefit',
				'label' => 'have_overtime_benefit',
				'placeholder' => 'Isikan have_overtime_benefit',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['1' => 'Ya', '0' => 'Tidak'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'risk_ratio' => [
				'id' => 'risk_ratio',
				'label' => 'risk_ratio',
				'placeholder' => 'Isikan risk_ratio',
				'type' => 'input',
				'value' => '',					
			]	,						
		'submit' => [
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan'
		]
	];

	public function joinReference(){
		if($this->getWithReferences()){
			$this->db->join('contracts','contracts.id = employees.contract_id');
			/*$this->db->join('companies','companies.id = employees.company_id');
			$this->db->join('departments','departments.id = employees.department_id');
			$this->db->join('job_levels','job_levels.id = employees.joblevel_id');
			*/$this->db->join('job_titles','job_titles.id = employees.jobtitle_id');
			/*$this->db->join('regions','regions.id = employees.region_of_birth_id');
			$this->db->join('cities','cities.id = employees.city_of_birth_id');
			*/$this->db->join('employees as emp','emp.id = employees.supervisor_id','left');
			$this->db->join('salary_groups','salary_groups.id = employees.salary_group_id','left');
			$this->db->join('shiftment_groups','shiftment_groups.id = employees.shiftment_group_id','left');
		}
	}

    /** uncomment function ini untuk memberikan nilai default form,
	  * misalkan mengisi data pilihan dropdown dari database dll
	*/  
    protected function setOptionDataForm($where = array()){		
		$this->load->model('company_model','cm');		
		$this->load->model('departement_model','dm');
		$this->load->model('salary_group_model','sgm');				
		$this->load->model('shiftment_group_model','shgm');

		if(!empty($where)){
			$dataModel = $this->get_by($where);			
			$this->load->model('region_model','rm');
			$regionBirth = $this->rm->as_array()->fields(['id','name'])->get($dataModel->region_of_birth_id);			
			$this->form['region_of_birth_id']['options'] = [$dataModel->region_of_birth_id => $regionBirth['name']];
			$this->load->model('city_model','ctym');		
			$cityBirth = $this->ctym->as_array()->fields(['id','name'])->get($dataModel->city_of_birth_id);			
			$this->form['city_of_birth_id']['options'] = [$dataModel->city_of_birth_id => $cityBirth['name']];
			$this->load->model('contract_model','ctm');
			$contract = $this->ctm->as_array()->fields(['id','letter_number'])->get($dataModel->contract_id);			
			$this->form['contract_id']['options'] = [$dataModel->contract_id => $contract['letter_number']];
			$this->load->model('job_title_model','jtm');		
			$jobTitle = $this->jtm->as_array()->fields(['id','name'])->get($dataModel->jobtitle_id);			
			$this->form['jobtitle_id']['options'] = [$dataModel->jobtitle_id => $jobTitle['name']];

			if(!empty($dataModel->supervisor_id)){
				$supervisor = $this->as_array()->fields(['id','full_name'])->get($dataModel->supervisor_id);			
				$this->form['supervisor_id']['options'] = [$dataModel->supervisor_id => $supervisor['full_name']];
			}
		}

		$listSalaryGroup = dropdown($this->sgm->fields('concat(code,\' - \',name) as name, id')->as_array()->get_all(),'id','name');                
		$listShiftmentGroup = dropdown($this->shgm->fields('concat(code,\' - \',name) as name, id')->as_array()->get_all(),'id','name');                
		if(!empty($listSalaryGroup)){
			$this->form['salary_group_id']['options'] = $listSalaryGroup;
		}
		if(!empty($listSalaryGroup)){
			$this->form['shiftment_group_id']['options'] = $listShiftmentGroup;
		}
		 
		$listCompany = dropdown($this->cm->fields('concat(code,\' - \',name) as name, id')->as_array()->get_all(),'id','name');                
		$listDepartement = dropdown($this->dm->fields('concat(code,\' - \',name) as name, id')->as_array()->get_all(),'id','name');            
		$this->form['company_id']['options'] = $listCompany;
		$this->form['department_id']['options'] = $listDepartement;        
	}
	
	public function setting_data($row){
		if(empty($row['supervisor_id'])){
			$row['supervisor_id'] = NULL;
		}
		
		if(strtolower($row['resign_date']) == 'invalid date'){
			$row['resign_date'] = NULL;
		}
		

		/** setting joblevel_id */
		$this->load->model('job_title_model', 'jtm');
		$jobtitle = $this->jtm->fields('job_level_id')->get($row['jobtitle_id']);
		$row['joblevel_id'] = $jobtitle->job_level_id;
		return $row;
	}
}
?>