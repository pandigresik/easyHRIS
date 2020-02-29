<?php
/** Generate by crud generator model pada 2020-02-25 08:53:57

*   Author afandi
*/
class Contract_model extends Base_model{
    protected $_table = 'contracts';
    protected $searchLookupColumn = 'letter_number';   
    protected $primary_key = 'id';
    protected $columnTableData = ['id','type','letter_number','subject','description','start_date','end_date','signed_date','tags','used'];
    protected $headerTableData = [				[['data' => 'type'],['data' => 'letter_number'],['data' => 'subject'],['data' => 'description'],['data' => 'start_date'],['data' => 'end_date'],['data' => 'signed_date'],['data' => 'tags'],['data' => 'used']]];

    protected $form = [			
			'id' => [
				'id' => 'id',
				'label' => 'id',
				'placeholder' => 'Isikan id',
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
			'letter_number' => [
				'id' => 'letter_number',
				'label' => 'letter_number',
				'placeholder' => 'Isikan letter_number',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'subject' => [
				'id' => 'subject',
				'label' => 'subject',
				'placeholder' => 'Isikan subject',
				'type' => 'input',
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
			'start_date' => [
				'id' => 'start_date',
				'label' => 'start_date',
				'placeholder' => 'Isikan start_date',
				            'type' => 'input',
            'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'end_date' => [
				'id' => 'end_date',
				'label' => 'end_date',
				'placeholder' => 'Isikan end_date',
				            'type' => 'input',
            'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'signed_date' => [
				'id' => 'signed_date',
				'label' => 'signed_date',
				'placeholder' => 'Isikan signed_date',
				            'type' => 'input',
            'data-tipe' => 'date',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'tags' => [
				'id' => 'tags',
				'label' => 'tags',
				'placeholder' => 'Isikan tags',
				'type' => 'input',
				'value' => '',	
				'required' => 'required'	
			]	,			
			'used' => [
				'id' => 'used',
				'label' => 'used',
				'placeholder' => 'Isikan used',
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