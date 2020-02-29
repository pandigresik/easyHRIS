<?php
/** Generate by crud generator model pada 2020-02-25 09:22:12

*   Author afandi
*/
class Workshift_model extends Base_model{
    protected $_table = 'workshifts';
	
    protected $primary_key = 'id';
    protected $columnTableData = ['employee_id','shiftment_id','description','work_date'];
    protected $headerTableData = [				[['data' => 'Pegawai'],['data' => 'Reference'],['data' => 'description'],['data' => 'work_date']]];

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
				'label' => 'Reference',
				'placeholder' => 'Isikan Reference',
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