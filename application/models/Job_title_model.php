<?php
/** Generate by crud generator model pada 2020-02-25 09:06:13

*   Author afandi
*/
class Job_title_model extends Base_model{
    protected $_table = 'job_titles';
	
    protected $primary_key = 'id';
    protected $columnTableData = ['job_levels.name as references','job_titles.code','job_titles.name'];
    protected $headerTableData = [				[['data' => 'Reference'],['data' => 'Kode'],['data' => 'Nama']]];

    protected $form = [			
			'job_level_id' => [
				'id' => 'job_level_id',
				'label' => 'Reference',
				'placeholder' => 'Isikan Reference',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/employees/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'code' => [
				'id' => 'code',
				'label' => 'Kode',
				'placeholder' => 'Isikan Kode',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'name' => [
				'id' => 'name',
				'label' => 'Nama',
				'placeholder' => 'Isikan Nama',
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
			$this->db->join('job_levels','job_levels.id = job_titles.job_level_id');
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