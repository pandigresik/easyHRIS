<?php

class menus extends Seeder {

    private $table = 'menus';
    protected $objModel = 'menu_model';     
    public function run() {
        $this->model->truncate();

        //seed records manually
        $datas = [
            ['name' => 'Master','description' => 'master data','route' => '#','icon' => 'fa fa-settings', 'parent_id' => NULL],
            ['name' => 'Master Menu','description' => 'master data menu','route' => 'master/menu','icon' => 'fa fa-settings', 'parent_id' => 1],
            ['name' => 'Master Role','description' => 'master data role','route' => 'master/role','icon' => 'fa fa-settings', 'parent_id' => 1]
        ];        

        //seed many records using faker
        $limit = count($datas);
        echo "seeding $limit data";

        for ($i = 0; $i < $limit; $i++) {
            echo ".";            
            $data = $datas[$i];
            $this->model->insert($data);
        }

        echo PHP_EOL;
    }
}
