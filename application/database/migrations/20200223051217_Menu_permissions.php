<?php

class Migration_Menu_permissions extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(            
            'menu_id' => array(
                'type' => 'INT',
                'constraint' => 11,                
            ),
            'permission_id' => array(
                'type' => 'INT',
                'constraint' => 11,                
            ),
        ));
        $this->dbforge->add_key(['menu_id','permission_id'], TRUE);
        $this->dbforge->create_table('menu_permissions');
    }

    public function down() {
        $this->dbforge->drop_table('menu_permissions');
    }

}