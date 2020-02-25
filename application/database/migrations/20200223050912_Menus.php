<?php

class Migration_Menus extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'auto_increment' => TRUE
            ),            
            'name' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'unique' => TRUE
            ),
            'description' => array(
                'type' => 'varchar',
                'constraint' => 100,
                'null' => TRUE
            ),
            'status' => array(
                'type' => 'char',
                'constraint' => 1,                
                'default' => 1
            ),
            'created_at' => array(
                'type' => 'DATETIME'                
            ),
            'updated_at' => array(
                'type' => 'DATETIME'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('menus');
    }

    public function down() {
        $this->dbforge->drop_table('menus');
    }

}