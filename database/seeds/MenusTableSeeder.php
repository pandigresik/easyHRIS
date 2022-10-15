<?php



use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Master Data',
                'description' => 'Header menu master',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-address-book',
                'route' => NULL,
                'parent_id' => NULL,
                '_lft' => 3,
                '_rgt' => 22,
                'seq_number' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Accounting',
                'description' => 'Header menu accounting',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-10-04 11:10:58',
                'icon' => 'cil-address-book',
                'route' => NULL,
                'parent_id' => NULL,
                '_lft' => 23,
                '_rgt' => 26,
                'seq_number' => 2,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Inventory',
                'description' => 'Header menu inventory',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-10-04 11:10:58',
                'icon' => 'cil-address-book',
                'route' => NULL,
                'parent_id' => NULL,
                '_lft' => 27,
                '_rgt' => 28,
                'seq_number' => 3,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Menu',
                'description' => 'Manage menu',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-address-book',
                'route' => 'base/menus',
                'parent_id' => 1,
                '_lft' => 14,
                '_rgt' => 15,
                'seq_number' => 1,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'User',
                'description' => 'Manage users',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-address-book',
                'route' => 'base/users',
                'parent_id' => 1,
                '_lft' => 16,
                '_rgt' => 17,
                'seq_number' => 2,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Role',
                'description' => 'Manage role',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-address-book',
                'route' => 'base/roles',
                'parent_id' => 1,
                '_lft' => 18,
                '_rgt' => 19,
                'seq_number' => 3,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'Permission',
                'description' => 'Manage permissions',
                'status' => '1',
                'created_at' => '2021-08-09 08:10:07',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-address-book',
                'route' => 'base/permissions',
                'parent_id' => 1,
                '_lft' => 20,
                '_rgt' => 21,
                'seq_number' => 1,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'HR',
                'description' => 'Human Resource',
                'status' => '1',
                'created_at' => '2022-09-22 09:41:02',
                'updated_at' => '2022-09-22 09:41:02',
                'icon' => 'cil-group',
                'route' => NULL,
                'parent_id' => NULL,
                '_lft' => 1,
                '_rgt' => 2,
                'seq_number' => 2,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Company',
                'description' => 'Master Company',
                'status' => '1',
                'created_at' => '2022-09-22 09:49:01',
                'updated_at' => '2022-09-22 09:56:35',
                'icon' => 'cil-building',
                'route' => 'base/companies',
                'parent_id' => 1,
                '_lft' => 12,
                '_rgt' => 13,
                'seq_number' => 5,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Departement',
                'description' => 'Departement',
                'status' => '1',
                'created_at' => '2022-09-22 09:50:29',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-border-all',
                'route' => 'base/departments',
                'parent_id' => 1,
                '_lft' => 10,
                '_rgt' => 11,
                'seq_number' => 6,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Region',
                'description' => 'Region / Wilayah',
                'status' => '1',
                'created_at' => '2022-09-22 09:53:07',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-map',
                'route' => 'base/regions',
                'parent_id' => 1,
                '_lft' => 8,
                '_rgt' => 9,
                'seq_number' => 7,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Setting',
                'description' => 'Setting Data Company',
                'status' => '1',
                'created_at' => '2022-09-22 09:53:53',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-settings',
                'route' => 'base/settings',
                'parent_id' => 1,
                '_lft' => 6,
                '_rgt' => 7,
                'seq_number' => 8,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'City',
                'description' => 'City',
                'status' => '1',
                'created_at' => '2022-09-22 09:55:32',
                'updated_at' => '2022-09-22 09:55:32',
                'icon' => 'cil-sitemap',
                'route' => 'base/cities',
                'parent_id' => 1,
                '_lft' => 4,
                '_rgt' => 5,
                'seq_number' => 8,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'Tax',
                'description' => 'Tax / pajak',
                'status' => '1',
                'created_at' => '2022-10-04 11:10:58',
                'updated_at' => '2022-10-04 11:10:58',
                'icon' => 'cil-money',
                'route' => 'accounting/taxes',
                'parent_id' => 2,
                '_lft' => 24,
                '_rgt' => 25,
                'seq_number' => 1,
            ),
        ));
        
        
    }
}