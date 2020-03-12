<?php
/** Generate by crud generator model pada 2020-02-25 09:01:11

*   Author afandi
*/
class Holiday_model extends Base_model{
    protected $_table = 'holidays';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','holiday_date','name'];
    protected $headerTableData = [				[['data' => 'holiday_date'],['data' => 'Nama']]];

    protected $form = [						
			'holiday_date' => [
				'id' => 'holiday_date',
				'label' => 'holiday_date',
				'placeholder' => 'Isikan holiday_date',
				            'type' => 'input',
            'data-tipe' => 'date',
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