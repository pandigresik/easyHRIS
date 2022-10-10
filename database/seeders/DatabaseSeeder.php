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
          
        $this->call(RegionsTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(AbsentReasonsTableSeeder::class);                
        $this->call(CompaniesTableSeeder::class);
        // $this->call(CompanyCostsTableSeeder::class);
        // $this->call(CompanyDepartmentsTableSeeder::class);        
        $this->call(DepartmentsTableSeeder::class);
        $this->call(EducationTitlesTableSeeder::class);
        $this->call(EducationalInstitutesTableSeeder::class);                
        $this->call(JobLevelsTableSeeder::class);        
        $this->call(JobTitlesTableSeeder::class);       
        $this->call(SalaryAllowancesTableSeeder::class);
        $this->call(SalaryBenefitHistoriesTableSeeder::class);
        $this->call(SalaryBenefitsTableSeeder::class);
        // $this->call(SalaryComponentsTableSeeder::class);
        // $this->call(SalaryGroupDetailsTableSeeder::class);
        // $this->call(SalaryGroupsTableSeeder::class);
        $this->call(ShiftmentGroupsTableSeeder::class);
        $this->call(ShiftmentsTableSeeder::class);        
        $this->call(WorkshiftsTableSeeder::class);
        $this->call(MenusTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(MenuPermissionsTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
    }
}
