<?php
/** Generate by crud generator model pada 2020-02-29 20:14:24
*   Author afandi
*/
class Shiftment_group_model extends Base_model{
    protected $_table = 'shiftment_groups';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['shiftment_groups.id','shiftment_groups.code','companies.name as company','shiftments.name as shiftment','shiftment_groups.name'];
    protected $headerTableData = [				[['data' => 'code'],['data' => 'Perusahaan'],['data' => 'shift'],['data' => 'name']]];

    protected $form = [			
			'code' => [
				'id' => 'code',
				'label' => 'code',
				'placeholder' => 'Isikan code',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'company_id' => [
				'id' => 'company_id',
				'label' => 'company_id',
				'placeholder' => 'Isikan company_id',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => [''],
				'value' => '',	
				'required' => 'required'	
			]	,			
			'shiftment_id' => [
				'id' => 'shiftment_id',
				'label' => 'shiftment_id',
				'placeholder' => 'Isikan shiftment_id',
				'type' => 'dropdown',
				'class' => 'select2_single',
				'options' => [''],
				'value' => '',	
				'required' => 'required'	
			]	,			
			'name' => [
				'id' => 'name',
				'label' => 'name',
				'placeholder' => 'Isikan name',
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
	*/  
    protected function setOptionDataForm($where = array()){
		$this->load->model('company_model','cm');
		$this->load->model('shiftment_model','sm');
		$listCompany = dropdown($this->cm->as_array()->fields('id,concat(name,\' - \',code) as text')->get_all(),'id','text');
		$listShiftment = dropdown($this->sm->as_array()->fields('id,concat(name,\' - \',code,\'( \',start_hour,\'sd\',end_hour,\' )\' ) as text')->get_all(),'id','text');
		$this->form['company_id']['options'] = $listCompany;
		$this->form['shiftment_id']['options'] = $listShiftment;
	}
	
		public function joinReference(){
		if($this->getWithReferences()){
			$this->db->join('shiftments','shiftments.id = shiftment_groups.shiftment_id');
			$this->db->join('companies','companies.id = shiftment_groups.company_id');			
		}
	}

}
?>