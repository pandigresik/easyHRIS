<?php

class Migration_Role_permissions extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11,                
            ),
            'permission_id' => array(
                'type' => 'INT',
                'constraint' => 11,                
            ),
        ));
        $this->dbforge->add_key(['role_id','permission_id'], TRUE);
        $this->dbforge->create_table('role_permissions');
    }

    public function down() {
        $this->dbforge->drop_table('role_permissions');
    }

}