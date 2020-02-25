<?php

class Migration_User_roles extends CI_Migration {

    public function up() {
        $this->dbforge->add_field(array(
            'role_id' => array(
                'type' => 'INT',
                'constraint' => 11                
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 11                
            ),
            
        ));
        $this->dbforge->add_key(['role_id','user_id'], TRUE);
        $this->dbforge->create_table('user_roles');
    }

    public function down() {
        $this->dbforge->drop_table('user_roles');
    }

}