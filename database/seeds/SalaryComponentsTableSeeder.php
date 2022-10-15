<?php



use Illuminate\Database\Seeder;

class SalaryComponentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('salary_components')->delete();
        
        \DB::table('salary_components')->insert(array (
            0 => 
            array (
                'code' => 'UM',
                'name' => 'UANG MAKAN',
                'state' => 'p',
                'fixed' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            1 => 
            array (
                'code' => 'GP',
                'name' => 'GAJI POKOK',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            2 => 
            array (
                'code' => 'PL',
                'name' => 'POTONGAN LAIN-LAIN',
                'state' => 'm',
                'fixed' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            3 => 
            array (
                'code' => 'JPP',
                'name' => 'TUNJANGAN BPJS JP',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            4 => 
            array (
                'code' => 'PPH21P',
                'name' => 'TUNJANGAN PAJAK PPH21',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            5 => 
            array (
                'code' => 'JPM',
                'name' => 'POTONGAN BPJS JP',
                'state' => 'm',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            6 => 
            array (
                'code' => 'PPH21M',
                'name' => 'POTONGAN PAJAK PPH21',
                'state' => 'm',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            7 => 
            array (
                'code' => 'JHTC',
                'name' => 'TUNJANGAN BPJS JTH PERUSAHAAN',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            8 => 
            array (
                'code' => 'JKK',
                'name' => 'TUNJANGAN BPJS JKK PERUSAHAAN',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            9 => 
            array (
                'code' => 'JHTM',
                'name' => 'POTONGAN BPJS JTH',
                'state' => 'm',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            10 => 
            array (
                'code' => 'JHTP',
                'name' => 'TUNJANGAN BPJS JTH',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            11 => 
            array (
                'code' => 'JKM',
                'name' => 'TUNJANGAN BPJS JKM PERUSAHAAN',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            12 => 
            array (
                'code' => 'JPC',
                'name' => 'TUNJANGAN BPJS JP PERUSAHAAN',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            13 => 
            array (
                'code' => 'UT',
                'name' => 'UANG TRANSPORT',
                'state' => 'p',
                'fixed' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            14 => 
            array (
                'code' => 'OT',
                'name' => 'TUNJANGAN LEMBUR',
                'state' => 'p',
                'fixed' => 0,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            15 => 
            array (
                'code' => 'TJ',
                'name' => 'TUNJANGAN JABATAN',
                'state' => 'p',
                'fixed' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
        ));
        
        
    }
}