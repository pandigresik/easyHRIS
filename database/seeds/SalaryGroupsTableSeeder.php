<?php



use Illuminate\Database\Seeder;

class SalaryGroupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('salary_groups')->delete();
        
        \DB::table('salary_groups')->insert(array (
            0 => 
            array (
                'code' => 'P2WJC',
                'name' => 'Gaji karyawan kontrak',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-29 09:10:24',
                'updated_at' => '2020-02-29 09:10:24',
            ),
            1 => 
            array (
                'code' => 'P1WJC',
                'name' => 'Gaji staff',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-29 09:10:07',
                'updated_at' => '2020-02-29 09:10:07',
            ),
        ));
        
        
    }
}