<?php



use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'parent_id' => NULL,
                'address' => NULL,
                'code' => 'SSI',
                'name' => 'PT. SEMART SOLUSI INDONESIA',
                'birth_day' => '1977-11-17',
                'email' => 'admin@kejawenlab.com',
                'tax_number' => '338-00-0912-244',
                'created_by' => 1,
                'updated_by' => 1,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
        ));
        
        
    }
}