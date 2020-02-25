<?php

class Role_model extends Base_model
{   
    public $has_many = array('role_menu' => array('primary_key' => 'roles_id'));
    protected $columnTableData = ['id', 'role_name as name', 'status', 'created_at'];
    protected $headerTableData = [
        [ ['data' => 'Nama Peran'], ['data' => 'Status'], ['data' => 'Dibuat Pada']],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    protected $form = array(
        'name' => array(
            'id' => 'role_name',
            'label' => 'Nama Peran',
            'placeholder' => 'misal editor',
            'required' => 'required',
            'value' => '',
        ),
        
        'status' => array(
            'id' => 'status',
            'label' => 'Status',
            'required' => 'required',
            'type' => 'dropdown',
'class' => 'select2_ajax',
'options' => [''],
'data-url' => 'master/employees/searchPaging',
            'options' => array(
                'A' => 'Aktif',
                'I' => 'Non Aktif',
            ),
            'value' => '',
        ),
        'submit' => array(
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan',
        ),
    );
}

