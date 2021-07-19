<?php

class users extends Seeder {

    private $table = 'users';       
    protected $objModel = 'user_model';     
    public function run() {                
        $this->model->truncate();

        //seed records manually
        $data = [
            'username' => 'admin',            
        ];
        $data =  array_merge($data,SecurityManager::encode('admin'));
        $this->model->insert($data);

        //seed many records using faker
        $limit = 1;
        echo "seeding {$limit} user accounts";

        echo PHP_EOL;
    }
}