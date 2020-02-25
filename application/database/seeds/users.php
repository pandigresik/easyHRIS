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
        $limit = 3;
        echo "seeding $limit user accounts";

        for ($i = 0; $i < $limit; $i++) {
            echo ".";

            $data = array(
                'username' => $this->faker->unique()->userName,                
            );
            $data =  array_merge($data,SecurityManager::encode('1234'));
            $this->model->insert($data);
        }

        echo PHP_EOL;
    }
}