<?php

class Migration_add_column_parent_menus extends CI_Migration {

    public function up() {
        $this->dbforge->add_column('menus',['parent_id' => ['type' => 'int','constraint' => 11, 'null' => TRUE]]);
    }

    public function down() {
        $this->dbforge->drop_table('menus','parent_id');
    }

}