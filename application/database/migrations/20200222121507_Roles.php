<?php

class Migration_Roles extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'name' => array(
                'type' => 'varchar',
                'constraint' => 50,
                'unique' => TRUE
            ),
            'description' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE
            ),
            'created_at' => array(
                'type' => 'DATETIME',                                
                //'default' => 'CURRENT_TIMESTAMP', 
                //'default_string' => false
            ),
            'updated_at' => array(
                'type' => 'DATETIME',           
                //'default' => 'CURRENT_TIMESTAMP', 
                //'default_string' => false
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('roles');
    }

    public function down() {
        $this->dbforge->drop_table('roles');
    }

}