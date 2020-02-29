<?php
/** Generate by crud generator model pada 2020-02-28 05:30:35
*   Author afandi
*/
class Salary_group_detail_model extends Base_model{
    protected $_table = 'salary_group_details';    
    protected $primary_key = 'id';
    protected $columnTableData = ['salary_group_details.id','salary_components.name','component_value'];
    protected $headerTableData = [				[['data' => 'Komponen'],['data' => 'Nilai']]];

    protected $form = [			
			'component_id' => [
				'id' => 'component_id',
				'label' => 'component_id',
				'placeholder' => 'Isikan component_id',
                'type' => 'dropdown',
                'options' => [''],
                'class' => 'select2_single',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'component_value' => [
				'id' => 'component_value',
				'label' => 'component_value',
				'placeholder' => 'Isikan component_value',
                'type' => 'input',
                'data-tipe' => 'integer',
				'value' => '',	
				'required' => 'required'	
            ]	,
            'salary_group_id' => [
				'id' => 'salary_group_id',
				'label' => 'Group gaji',
				'placeholder' => 'Isikan component_id',
                'type' => 'input',                
                'readonly' => 'readonly',                
                'class' => 'hide references',
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
    */
    protected function setOptionDataForm($where = array()){
        $referenceId = $this->getReferencesValue();
        $whereStatementComponent = empty($referenceId) ? '1 = 1' : ' id not in (select component_id from salary_group_details where salary_group_id = \''.$referenceId.'\') ';
        $this->load->model('salary_component_model','scm');
        $listSalaryGroup = dropdown($this->scm->as_array()->fields('id,concat(code,\' - \',name,\' ( \',state,\' ) \') as text')->get_many_by($whereStatementComponent),'id','text');                        
        $this->form['component_id']['options'] = $listSalaryGroup;
    }    
    
    	public function joinReference(){
		if($this->getWithReferences()){			
			$this->db->join('salary_components','salary_components.id = salary_group_details.component_id');
		}
	}

    
}
?>