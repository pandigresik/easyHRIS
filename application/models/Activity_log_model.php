<?php

class Activity_log_model extends Base_model
{
    protected $_table = 'activity_log';
    protected $primaryKey = 'id';
    protected $columnTableData = ['activity_log.id', 'route', 'concat(substring(send_data,1,100),\' ...\') send_data', 'comment', 'users.username as created_by', 'activity_log.created_at'];
    protected $headerTableData = [
        [['data' => 'url'], ['data' => 'Data'], ['data' => 'Comment'], ['data' => 'Dibuat oleh'], ['data' => 'Dibuat Pada']],
    ];

    protected $before_get = array('joinUser');

    public function joinUser(){
        $this->_database->join('users', 'users.id = activity_log.created_by');
    }

    protected $form = [
            'route' => [
                'id' => 'route',
                'label' => 'Url',
                'type' => 'input',
                'value' => '',
                'readonly' => 'readonly',
            ],
            'send_data' => [
                'id' => 'send_data',
                'label' => 'Data',
                'type' => 'textarea',
                'rows' => 5,
                'value' => '',
                'readonly' => 'readonly',
            ],
            'comment' => [
                'id' => 'comment',
                'label' => 'Keterangan',
                'type' => 'input',
                'value' => '',
                'readonly' => 'readonly',
            ],
            'created_by' => [
                'id' => 'created_by',
                'label' => 'Dibuat Oleh',
                'type' => 'input',
                'value' => '',
                'readonly' => 'readonly',
            ],
            'created_at' => [
                'id' => 'created_at',
                'label' => 'Dibuat Pada',
                'type' => 'input',
                'value' => '',
                'readonly' => 'readonly',
            ],
        ];

        public function getEditData($key = array(), $toArray = true)
        {
            if ($toArray) {
                $data = $this->fields(['activity_log.*','users.username as created_by', 'activity_log.created_at'])->as_array()->get_by($key);
            } else {
                $data = $this->fields(['activity_log.*','users.username as created_by', 'activity_log.created_at'])->get_by($key);
            }
    
            return $data;
        }

        public function updated_at($row)
    {        
        return $row;
    }
}
