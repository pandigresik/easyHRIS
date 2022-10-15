<?php



use Illuminate\Database\Seeder;

class MenuPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menu_permissions')->delete();
        
        \DB::table('menu_permissions')->insert(array (
            0 => 
            array (
                'menu_id' => 4,
                'permission_id' => 1,
                'status' => '1',
            ),
            1 => 
            array (
                'menu_id' => 5,
                'permission_id' => 5,
                'status' => '1',
            ),
            2 => 
            array (
                'menu_id' => 6,
                'permission_id' => 9,
                'status' => '1',
            ),
            3 => 
            array (
                'menu_id' => 7,
                'permission_id' => 13,
                'status' => '1',
            ),
            4 => 
            array (
                'menu_id' => 9,
                'permission_id' => 149,
                'status' => '1',
            ),
            5 => 
            array (
                'menu_id' => 10,
                'permission_id' => 141,
                'status' => '1',
            ),
            6 => 
            array (
                'menu_id' => 11,
                'permission_id' => 153,
                'status' => '1',
            ),
            7 => 
            array (
                'menu_id' => 12,
                'permission_id' => 157,
                'status' => '1',
            ),
            8 => 
            array (
                'menu_id' => 13,
                'permission_id' => 145,
                'status' => '1',
            ),
            9 => 
            array (
                'menu_id' => 14,
                'permission_id' => 17,
                'status' => '1',
            ),
        ));
        
        
    }
}