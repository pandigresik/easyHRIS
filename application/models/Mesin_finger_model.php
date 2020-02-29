<?php

class Mesin_finger_model extends MY_Model
{   
    protected $_table = 'sys_config_finger_device_allocation';
    
    protected $columnTableData = ['id', 'display_name', 'serial_number', 'location_id', 'created_at'];
    protected $headerTableData = [
        [['data' => 'Id'], ['data' => 'Nama'], ['data' => 'No. Seri'], ['data' => 'Lokasi'], ['data' => 'Dibuat Pada'], ['data' => 'Aksi']],
    ];

    public function __construct()
    {
        parent::__construct();
    }

    protected $form = array(
        'display_name' => array(
            'id' => 'display_name',
            'label' => 'Nama Mesin',
            'placeholder' => 'misal BSF0301',
            'required' => 'required',
            'value' => '',
        ),
        'serial_number' => array(
            'id' => 'serial_number',
            'label' => 'Nomer Seri',
            'required' => 'required',
            'placeholder' => 'nomer seri',
            'value' => '',
        ),
        'location_id' => array(
            'id' => 'location_id',
            'label' => 'Id Lokasi',
            'required' => 'required',
            'placeholder' => 'id lokasi',
            'value' => '',
        ),
        
        'submit' => array(
            'id' => 'submit',
            'type' => 'submit',
            'label' => 'Simpan',
        ),
    );
}

