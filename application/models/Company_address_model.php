<?php
/** Generate by crud generator model pada 2020-02-25 08:45:15

*   Author afandi
*/
class Company_address_model extends Base_model{
    protected $_table = 'company_addresses';
    
    protected $primary_key = 'id';
    protected $columnTableData = ['id','company_id','region_id','city_id','address','postal_code','phone_number','fax_number','default_address'];
    protected $headerTableData = [				[['data' => 'Company'],['data' => 'Wilayah'],['data' => 'Kota'],['data' => 'Alamat'],['data' => 'Kode pos'],['data' => 'Telephon'],['data' => 'Fax'],['data' => 'Alamat (default)']]];

    protected $form = [						
			'company_id' => [
				'id' => 'company_id',
				'label' => 'Perusahaan',
				'placeholder' => 'Isikan Perusahaan',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/companies/searchPaging',
				'value' => '',					
			]	,			
			'region_id' => [
				'id' => 'region_id',
				'label' => 'Wilayah',
				'placeholder' => 'Isikan Wilayah',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/regions/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'city_id' => [
				'id' => 'city_id',
				'label' => 'Kota',				
				'placeholder' => 'Isikan Wilayah',
				'type' => 'dropdown',
				'class' => 'select2_ajax',
				'options' => [''],
				'data-url' => 'master/cities/searchPaging',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'address' => [
				'id' => 'address',
				'label' => 'Alamat',
				'placeholder' => 'Isikan Alamat',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'postal_code' => [
				'id' => 'postal_code',
				'label' => 'Kode pos',
				'placeholder' => 'Isikan Kode pos',
				'type' => 'input',
				'data-tipe' => 'angka',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'phone_number' => [
				'id' => 'phone_number',
				'label' => 'Telephon',
				'placeholder' => 'Isikan Telephon',
				'type' => 'input',				
				'value' => '',	
				'required' => 'required'	
			]	,			
			'fax_number' => [
				'id' => 'fax_number',
				'label' => 'Fax',
				'placeholder' => 'Isikan Fax',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'default_address' => [
				'id' => 'default_address',
				'label' => 'Alamat (default)',
				'placeholder' => 'Isikan Alamat (default)',
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