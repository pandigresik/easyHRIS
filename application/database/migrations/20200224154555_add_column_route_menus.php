<?php

class Migration_add_column_route_menus extends CI_Migration {

    public function up() {                
        $this->dbforge->add_column('menus',['icon' => ['type' => 'varchar','constraint' => 50]]);
        $this->dbforge->add_column('menus',['route' => ['type' => 'varchar','constraint' => 100,'NULL' => TRUE]]);
    }

    public function down() {
        $this->dbforge->drop_column('menus','icon');
        $this->dbforge->drop_column('menus','route');
    }

}