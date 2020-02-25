<?php

class roles extends Seeder {

    private $table = 'roles';
    protected $objModel = 'role_model';     
    public function run() {
        $this->model->truncate();

        //seed records manually
        $roles = [
            ['name' => 'administrator','description' => 'as system administrator, top level'],
            ['name' => 'supervisor','description' => 'supervisor level'],
            ['name' => 'staff','description' => 'staff level'],
        ];                
        echo "seeding ".count($roles)." role";

        for ($i = 0; $i < count($roles); $i++) {
            $data = $roles[$i]; 
            $this->model->insert($data);
        }

        echo PHP_EOL;
    }
}
