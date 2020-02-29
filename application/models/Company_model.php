<?php
/** Generate by crud generator model pada 2020-02-25 08:31:54

*   Author afandi
*/
class Company_model extends Base_model{
    protected $_table = 'companies';
	protected $searchLookupColumn = 'name';    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','parent_id','address','code','name','birth_day','email','tax_number'];
    protected $headerTableData = [				[['data' => 'Reference'],['data' => 'Alamat'],['data' => 'Kode'],['data' => 'Nama'],['data' => 'Tanggal Lahir'],['data' => 'email'],['data' => 'NPWP']]];

    protected $form = [			
			'parent_id' => [
				'id' => 'parent_id',
				'label' => 'Reference',
				'placeholder' => 'Isikan Reference',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'data-url' => 'master/companies/searchPaging',
				'options' => [''],
				'value' => '',	
				'required' => 'required'	
			]	,			
			'address' => [
				'id' => 'address',
				'label' => 'Alamat',
				'placeholder' => 'Isikan Alamat',
				'type' => 'textarea',
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
			'birth_day' => [
				'id' => 'birth_day',
				'label' => 'Tanggal Lahir',
				'placeholder' => 'Isikan Tanggal Lahir',
				'type' => 'input',
				'data-tipe' => 'date',
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
			'tax_number' => [
				'id' => 'tax_number',
				'label' => 'NPWP',
				'placeholder' => 'Isikan NPWP',
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