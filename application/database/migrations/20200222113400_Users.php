<?php

class Migration_Users extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),
            'username' => array(
                'type' => 'varchar',
                'constraint' => 50,
                'unique' => TRUE                
            ),
            'password' => array(
                'type' => 'varchar',
                'constraint' => 60                
            ),
            'password_salt' => array(
                'type' => 'varchar',
                'constraint' => 255                
            ),
            'status' => array(
                'type' => 'char',
                'constraint' => 1,
                'default' => '1'                
            ),
            'created_at' => array(
                'type' => 'datetime'                               
            ),
            'updated_at' => array(
                'type' => 'datetime'                               
            )
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
    }

    public function down() {
        $this->dbforge->drop_table('users');
    }

}