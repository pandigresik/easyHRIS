<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {        
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(MenusTableSeeder::class);                
        $this->call(RolesTableSeeder::class);
        //$this->call(SettingTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(MenuPermissionsTableSeeder::class);

        \App\Models\Base\MenusTree::fixTree();  
                
        $this->call(AbsentReasonsTableSeeder::class);                
        $this->call(CompaniesTableSeeder::class);        
        $this->call(DepartmentsTableSeeder::class);
        $this->call(EducationTitlesTableSeeder::class);
        $this->call(EducationalInstitutesTableSeeder::class);        
        $this->call(SalaryComponentsTableSeeder::class);        
        $this->call(SalaryGroupsTableSeeder::class);        
        $this->call(ShiftmentsTableSeeder::class);        
    }
}
