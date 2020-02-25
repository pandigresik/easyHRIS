<?php
/** Generate by crud generator model pada 2020-02-25 09:00:04
*   Author afandi
*/
class Employee_model extends Base_model{	
	protected $_table = 'employees';
	protected $searchLookupColumn = 'full_name';    
	private $withReferences = FALSE;
    protected $before_get = array('joinReference');    
    protected $primary_key = 'id';
    protected $columnTableData = ['employees.id','contracts.letter_number','companies.name as company','departments.name as departement','job_levels.name as joblevel','job_titles.name as jobtitle','emp.full_name as supervisor','regions.name as region','cities.name as city','employees.address_id','employees.join_date','employees.employee_status','employees.code','employees.full_name','employees.gender','employees.date_of_birth','employees.identity_number','employees.identity_type','employees.marital_status','employees.email','employees.leave_balance','employees.tax_group','employees.resign_date','employees.have_overtime_benefit'];
    protected $headerTableData = [				[['data' => 'contract_id'],['data' => 'company_id'],['data' => 'department_id'],['data' => 'joblevel_id'],['data' => 'jobtitle_id'],['data' => 'supervisor_id'],['data' => 'region_of_birth_id'],['data' => 'city_of_birth_id'],['data' => 'address_id'],['data' => 'join_date'],['data' => 'employee_status'],['data' => 'code'],['data' => 'full_name'],['data' => 'gender'],['data' => 'date_of_birth'],['data' => 'identity_number'],['data' => 'identity_type'],['data' => 'marital_status'],['data' => 'email'],['data' => 'leave_balance'],['data' => 'tax_group'],['data' => 'resign_date'],['data' => 'have_overtime_benefit']]];

    protected $form = [						
			'contract_id' => [
				'id' => 'contract_id',
				'label' => 'contract_id',
				'placeholder' => 'Isikan contract_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/contracts/searchPaging',
				'value' => '',					
			]	,			
			'company_id' => [
				'id' => 'company_id',
				'label' => 'company_id',
				'placeholder' => 'Isikan company_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/companies/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'department_id' => [
				'id' => 'department_id',
				'label' => 'department_id',
				'placeholder' => 'Isikan department_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/departements/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'joblevel_id' => [
				'id' => 'joblevel_id',
				'label' => 'joblevel_id',
				'placeholder' => 'Isikan joblevel_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/job_levels/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'jobtitle_id' => [
				'id' => 'jobtitle_id',
				'label' => 'jobtitle_id',
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
				'label' => 'supervisor_id',
				'placeholder' => 'Isikan supervisor_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'region_of_birth_id' => [
				'id' => 'region_of_birth_id',
				'label' => 'Tempat lahir',
				'placeholder' => 'Isikan region_of_birth_id',
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
				'placeholder' => 'Isikan city_of_birth_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/cities/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'address_id' => [
				'id' => 'address_id',
				'label' => 'address_id',
				'placeholder' => 'Isikan address_id',
				'type' => 'input',
				'value' => '',					
			]	,			
			'join_date' => [
				'id' => 'join_date',
				'label' => 'join_date',
				'placeholder' => 'Isikan join_date',
				'type' => 'input',
				'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'employee_status' => [
				'id' => 'employee_status',
				'label' => 'employee_status',
				'placeholder' => 'Isikan employee_status',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['K' => 'Kontrak', 'T' => 'Tetap'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'code' => [
				'id' => 'code',
				'label' => 'code',
				'placeholder' => 'Isikan code',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'full_name' => [
				'id' => 'full_name',
				'label' => 'full_name',
				'placeholder' => 'Isikan full_name',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'gender' => [
				'id' => 'gender',
				'label' => 'gender',
				'placeholder' => 'Isikan gender',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['M' => 'Pria','F' => 'Wanita'],
				'data-url' => 'master/departements/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'date_of_birth' => [
				'id' => 'date_of_birth',
				'label' => 'date_of_birth',
				'placeholder' => 'Isikan date_of_birth',
				'type' => 'input',
				'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'identity_number' => [
				'id' => 'identity_number',
				'label' => 'identity_number',
				'placeholder' => 'Isikan identity_number',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'identity_type' => [
				'id' => 'identity_type',
				'label' => 'identity_type',
				'placeholder' => 'Isikan identity_type',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['KTP' => 'KTP','SIM' => 'SIM','PASSPOR' => 'Passpor'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'marital_status' => [
				'id' => 'marital_status',
				'label' => 'marital_status',
				'placeholder' => 'Isikan marital_status',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => ['M' => 'Menikah', 'BM' => 'Belum Menikah', 'TM' => 'Duda / Janda'],				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'email' => [
				'id' => 'email',
				'label' => 'email',
				'placeholder' => 'Isikan email',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'leave_balance' => [
				'id' => 'leave_balance',
				'label' => 'leave_balance',
				'placeholder' => 'Isikan leave_balance',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'tax_group' => [
				'id' => 'tax_group',
				'label' => 'tax_group',
				'placeholder' => 'Isikan tax_group',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'resign_date' => [
				'id' => 'resign_date',
				'label' => 'resign_date',
				'placeholder' => 'Isikan resign_date',
				'type' => 'input',
				'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
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
				'required' => 'required'	
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
			$this->db->join('companies','companies.id = employees.company_id');
			$this->db->join('departments','departments.id = employees.department_id');
			$this->db->join('job_levels','job_levels.id = employees.joblevel_id');
			$this->db->join('job_titles','job_titles.id = employees.jobtitle_id');
			$this->db->join('regions','regions.id = employees.region_of_birth_id');
			$this->db->join('cities','cities.id = employees.city_of_birth_id');
			$this->db->join('employees as emp','emp.id = employees.supervisor_id','left');
			
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

	/**
	 * Get the value of withReferences
	 */ 
	public function getWithReferences()
	{
		return $this->withReferences;
	}

	/**
	 * Set the value of withReferences
	 *
	 * @return  self
	 */ 
	public function setWithReferences($withReferences)
	{
		$this->withReferences = $withReferences;
		return $this;
	}
}
?>