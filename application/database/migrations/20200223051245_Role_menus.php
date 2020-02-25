<?php

class Migration_Role_menus extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11,                
            ),
            'menu_id' => array(
                'type' => 'INT',
                'constraint' => 11,                
            ),
        ));
        $this->dbforge->add_key(['role_id','menu_id'], TRUE);
        $this->dbforge->create_table('role_menus');
    }

    public function down() {
        $this->dbforge->drop_table('role_menus');
    }

}