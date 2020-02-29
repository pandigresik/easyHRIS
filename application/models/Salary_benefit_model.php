<?php
/** Generate by crud generator model pada 2020-02-25 09:17:47

*   Author afandi
*/
class Salary_benefit_model extends Base_model{
    protected $_table = 'salary_benefits';	
    protected $primary_key = 'id';
    protected $columnTableData = ['employees.full_name','salary_components.name','benefit_value','benefit_key'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'component_id'],['data' => 'benefit_value'],['data' => 'benefit_key']]];

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
			'component_id' => [
				'id' => 'component_id',
				'label' => 'component_id',
				'placeholder' => 'Isikan component_id',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/salary_components/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'benefit_value' => [
				'id' => 'benefit_value',
				'label' => 'benefit_value',
				'placeholder' => 'Isikan benefit_value',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'benefit_key' => [
				'id' => 'benefit_key',
				'label' => 'benefit_key',
				'placeholder' => 'Isikan benefit_key',
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
	
	public function joinReference(){
		if($this->getWithReferences()){
			$this->db->join('employees','employees.id = salary_benefits.employee_id');
			$this->db->join('salary_components','salary_components.id = salary_benefits.component_id');
		}		
	}
}
?>