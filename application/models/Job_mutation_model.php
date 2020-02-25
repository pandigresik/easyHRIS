<?php
/** Generate by crud generator model pada 2020-02-25 09:05:02

*   Author afandi
*/
class Job_mutation_model extends Base_model{
    protected $_table = 'job_placements';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','employee_id','old_company_id','old_department_id','old_joblevel_id','old_jobtitle_id','old_supervisor_id','new_company_id','new_department_id','new_joblevel_id','new_jobtitle_id','new_supervisor_id','contract_id','type','created_by','updated_by','deleted_at','created_at','updated_at'];
    protected $headerTableData = [				[['data' => 'employee_id'],['data' => 'old_company_id'],['data' => 'old_department_id'],['data' => 'old_joblevel_id'],['data' => 'old_jobtitle_id'],['data' => 'old_supervisor_id'],['data' => 'new_company_id'],['data' => 'new_department_id'],['data' => 'new_joblevel_id'],['data' => 'new_jobtitle_id'],['data' => 'new_supervisor_id'],['data' => 'contract_id'],['data' => 'type'],['data' => 'created_by'],['data' => 'updated_by'],['data' => 'deleted_at'],['data' => 'created_at'],['data' => 'updated_at']]];

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
			'old_company_id' => [
				'id' => 'old_company_id',
				'label' => 'old_company_id',
				'placeholder' => 'Isikan old_company_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'old_department_id' => [
				'id' => 'old_department_id',
				'label' => 'old_department_id',
				'placeholder' => 'Isikan old_department_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'old_joblevel_id' => [
				'id' => 'old_joblevel_id',
				'label' => 'old_joblevel_id',
				'placeholder' => 'Isikan old_joblevel_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'old_jobtitle_id' => [
				'id' => 'old_jobtitle_id',
				'label' => 'old_jobtitle_id',
				'placeholder' => 'Isikan old_jobtitle_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'old_supervisor_id' => [
				'id' => 'old_supervisor_id',
				'label' => 'old_supervisor_id',
				'placeholder' => 'Isikan old_supervisor_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_company_id' => [
				'id' => 'new_company_id',
				'label' => 'new_company_id',
				'placeholder' => 'Isikan new_company_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_department_id' => [
				'id' => 'new_department_id',
				'label' => 'new_department_id',
				'placeholder' => 'Isikan new_department_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_joblevel_id' => [
				'id' => 'new_joblevel_id',
				'label' => 'new_joblevel_id',
				'placeholder' => 'Isikan new_joblevel_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_jobtitle_id' => [
				'id' => 'new_jobtitle_id',
				'label' => 'new_jobtitle_id',
				'placeholder' => 'Isikan new_jobtitle_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'new_supervisor_id' => [
				'id' => 'new_supervisor_id',
				'label' => 'new_supervisor_id',
				'placeholder' => 'Isikan new_supervisor_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'contract_id' => [
				'id' => 'contract_id',
				'label' => 'contract_id',
				'placeholder' => 'Isikan contract_id',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'type' => [
				'id' => 'type',
				'label' => 'type',
				'placeholder' => 'Isikan type',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'created_by' => [
				'id' => 'created_by',
				'label' => 'created_by',
				'placeholder' => 'Isikan created_by',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'updated_by' => [
				'id' => 'updated_by',
				'label' => 'updated_by',
				'placeholder' => 'Isikan updated_by',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'deleted_at' => [
				'id' => 'deleted_at',
				'label' => 'deleted_at',
				'placeholder' => 'Isikan deleted_at',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'created_at' => [
				'id' => 'created_at',
				'label' => 'created_at',
				'placeholder' => 'Isikan created_at',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'updated_at' => [
				'id' => 'updated_at',
				'label' => 'updated_at',
				'placeholder' => 'Isikan updated_at',
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