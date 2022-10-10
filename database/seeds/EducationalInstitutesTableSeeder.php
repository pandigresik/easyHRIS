<?php



use Illuminate\Database\Seeder;

class EducationalInstitutesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('educational_institutes')->delete();
        
        \DB::table('educational_institutes')->insert(array (
            0 => 
            array (
                'name' => 'UNIVERSITAS GUNADARMA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            1 => 
            array (
                'name' => 'UNIVERSITAS NEGERI JAKARTA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            2 => 
            array (
                'name' => 'UNIVERSITAS BISNIS INDONESIA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            3 => 
            array (
                'name' => 'UNIVERSITAS MUHAMMADIYAH JAKARTA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            4 => 
            array (
                'name' => 'UNIVERSITAS TRISAKSI',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            5 => 
            array (
                'name' => 'UNIVERSITAS ISLAM INDONESIA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            6 => 
            array (
                'name' => 'UNIVERSITAS PANCASILA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            7 => 
            array (
                'name' => 'UNIVERSITAS ISLAM NEGERI SYARIF HIDAYATULLAH',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            8 => 
            array (
                'name' => 'UNIVERSITAS INDONESIA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            9 => 
            array (
                'name' => 'UNIVERSITAS PENDIDIKAN INDONESIA',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
        ));
        
        
    }
}