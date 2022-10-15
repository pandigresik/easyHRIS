<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('regions')->delete();
        
        \DB::table('regions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code' => '11',
                'name' => 'ACEH',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            1 => 
            array (
                'id' => 2,
                'code' => '12',
                'name' => 'SUMATERA UTARA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            2 => 
            array (
                'id' => 3,
                'code' => '13',
                'name' => 'SUMATERA BARAT',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            3 => 
            array (
                'id' => 4,
                'code' => '14',
                'name' => 'RIAU',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            4 => 
            array (
                'id' => 5,
                'code' => '15',
                'name' => 'JAMBI',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            5 => 
            array (
                'id' => 6,
                'code' => '16',
                'name' => 'SUMATERA SELATAN',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            6 => 
            array (
                'id' => 7,
                'code' => '17',
                'name' => 'BENGKULU',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            7 => 
            array (
                'id' => 8,
                'code' => '18',
                'name' => 'LAMPUNG',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            8 => 
            array (
                'id' => 9,
                'code' => '19',
                'name' => 'KEPULAUAN BANGKA BELITUNG',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            9 => 
            array (
                'id' => 10,
                'code' => '21',
                'name' => 'KEPULAUAN RIAU',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            10 => 
            array (
                'id' => 11,
                'code' => '31',
                'name' => 'DKI JAKARTA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            11 => 
            array (
                'id' => 12,
                'code' => '32',
                'name' => 'JAWA BARAT',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            12 => 
            array (
                'id' => 13,
                'code' => '33',
                'name' => 'JAWA TENGAH',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            13 => 
            array (
                'id' => 14,
                'code' => '34',
                'name' => 'DI YOGYAKARTA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            14 => 
            array (
                'id' => 15,
                'code' => '35',
                'name' => 'JAWA TIMUR',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            15 => 
            array (
                'id' => 16,
                'code' => '36',
                'name' => 'B A N T E N',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            16 => 
            array (
                'id' => 17,
                'code' => '51',
                'name' => 'B A L I',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            17 => 
            array (
                'id' => 18,
                'code' => '52',
                'name' => 'NUSA TENGGARA BARAT',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            18 => 
            array (
                'id' => 19,
                'code' => '53',
                'name' => 'NUSA TENGGARA TIMUR',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            19 => 
            array (
                'id' => 20,
                'code' => '61',
                'name' => 'KALIMANTAN BARAT',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            20 => 
            array (
                'id' => 21,
                'code' => '62',
                'name' => 'KALIMANTAN TENGAH',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            21 => 
            array (
                'id' => 22,
                'code' => '63',
                'name' => 'KALIMANTAN SELATAN',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            22 => 
            array (
                'id' => 23,
                'code' => '64',
                'name' => 'KALIMANTAN TIMUR',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            23 => 
            array (
                'id' => 24,
                'code' => '65',
                'name' => 'KALIMANTAN UTARA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            24 => 
            array (
                'id' => 25,
                'code' => '71',
                'name' => 'SULAWESI UTARA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            25 => 
            array (
                'id' => 26,
                'code' => '72',
                'name' => 'SULAWESI TENGAH',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            26 => 
            array (
                'id' => 27,
                'code' => '73',
                'name' => 'SULAWESI SELATAN',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            27 => 
            array (
                'id' => 28,
                'code' => '74',
                'name' => 'SULAWESI TENGGARA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            28 => 
            array (
                'id' => 29,
                'code' => '75',
                'name' => 'GORONTALO',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            29 => 
            array (
                'id' => 30,
                'code' => '76',
                'name' => 'SULAWESI BARAT',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            30 => 
            array (
                'id' => 31,
                'code' => '81',
                'name' => 'MALUKU',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            31 => 
            array (
                'id' => 32,
                'code' => '82',
                'name' => 'MALUKU UTARA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            32 => 
            array (
                'id' => 33,
                'code' => '91',
                'name' => 'PAPUA',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            33 => 
            array (
                'id' => 34,
                'code' => '92',
                'name' => 'PAPUA BARAT',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
            34 => 
            array (
                'id' => 35,
                'code' => '99',
                'name' => 'Kota Baru Buka',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-25 13:38:32',
                'updated_at' => '2020-02-25 13:38:32',
            ),
        ));
        
        
    }
}