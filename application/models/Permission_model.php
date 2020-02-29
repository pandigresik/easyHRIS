<?php

class Permission_model extends MY_Model
{   
    protected $columnTableData = ['id', 'name', 'route'];
    protected $return_type = 'array';
    protected $headerTableData = [
        [ ['data' => 'Nama'], ['data' => 'Route'], ['data' => 'Aksi']],
    ];
    public function __construct()
    {
        parent::__construct();
    }

    protected $form = array(
        'name' => array(
            'id' => 'name',
            'label' => 'Name',
            'placeholder' => 'nama menu',
            'required' => 'required',
            'value' => '',
        ),
        'route' => array(
            'id' => 'route',
            'label' => 'Route',
            'placeholder' => 'route atau url ',
            'required' => 'required',
            'value' => '',
        ),
        'menus_id' => array(
            'id' => 'menus_id',
            'readonly' => 'readonly',
            'required' => 'required',
            'value' => '',
        ),
        'submit' => array(
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan',
        ),
    );
}
