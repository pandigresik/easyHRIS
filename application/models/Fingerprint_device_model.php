<?php
/** Generate by crud generator model pada 2020-03-05 05:29:55
*   Author afandi
*/
class Fingerprint_device_model extends Base_model{
    protected $_table = 'fingerprint_devices';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','serial_number','ip','display_name'];
    protected $headerTableData = [				[['data' => 'Nomer Seri'],['data' => 'Ip'],['data' => 'Nama Mesin']]];

    protected $form = [			'serial_number' => [
				'id' => 'serial_number',
				'label' => 'Nomer Seri',
				'placeholder' => 'Isikan serial_number',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			'ip' => [
				'id' => 'ip',
				'label' => 'IP',
				'placeholder' => 'Isikan ip',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			'display_name' => [
				'id' => 'display_name',
				'label' => 'Nama Mesin',
				'placeholder' => 'Isikan display_name',
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