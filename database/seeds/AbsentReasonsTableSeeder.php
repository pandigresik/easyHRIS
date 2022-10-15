<?php



use Illuminate\Database\Seeder;

class AbsentReasonsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('absent_reasons')->delete();
        
        \DB::table('absent_reasons')->insert(array (
            0 => 
            array (
                'type' => 'l',
                'code' => 'CT',
                'name' => 'CUTI TAHUNAN',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            1 => 
            array (
                'type' => 'a',
                'code' => 'SKT',
                'name' => 'SAKIT SURAT DOKTER',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            2 => 
            array (
                'type' => 'a',
                'code' => 'ABS',
                'name' => 'TANPA KETERANGAN',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
        ));
        
        
    }
}