<?php



use Illuminate\Database\Seeder;

class EducationTitlesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('education_titles')->delete();
        
        \DB::table('education_titles')->insert(array (
            0 => 
            array (
                'short_name' => 'S.Ag',
                'name' => 'SARJANA AGAMA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            1 => 
            array (
                'short_name' => 'S.Pd',
                'name' => 'SARJANA PENDIDIKAN',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            2 => 
            array (
                'short_name' => 'S.E',
                'name' => 'SARJANA EKONOMI',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            3 => 
            array (
                'short_name' => 'S.Kom',
                'name' => 'SARJANA KOMPUTER',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            4 => 
            array (
                'short_name' => 'S.Sos',
                'name' => 'SARJANA SOSIAL',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            5 => 
            array (
                'short_name' => 'S.T',
                'name' => 'SARJANA TEKNIK',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            6 => 
            array (
                'short_name' => 'S.H',
                'name' => 'SARJANA HUKUM',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
        ));
        
        
    }
}