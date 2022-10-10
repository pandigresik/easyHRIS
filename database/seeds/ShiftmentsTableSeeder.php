<?php



use Illuminate\Database\Seeder;

class ShiftmentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shiftments')->delete();
        
        \DB::table('shiftments')->insert(array (
            0 => 
            array (
                'code' => 'SHF3',
                'name' => 'Shift 3',
                'start_hour' => '23:00:00',
                'end_hour' => '07:00:00',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-27 11:00:51',
                'updated_at' => '2020-02-27 11:00:51',
            ),
            1 => 
            array (
                'code' => 'SHFL',
                'name' => 'Libur',
                'start_hour' => '00:00:00',
                'end_hour' => '00:00:00',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-03-02 13:10:43',
                'updated_at' => '2020-03-02 13:10:43',
            ),
            2 => 
            array (
                'code' => 'SHF2',
                'name' => 'Shift 2',
                'start_hour' => '15:00:00',
                'end_hour' => '23:00:00',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-27 11:00:22',
                'updated_at' => '2020-02-27 11:00:22',
            ),
            3 => 
            array (
                'code' => 'SHF1',
                'name' => 'Shift 1',
                'start_hour' => '07:00:00',
                'end_hour' => '15:00:00',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-27 10:59:45',
                'updated_at' => '2020-02-27 10:59:45',
            ),
            4 => 
            array (
                'code' => 'NSFT',
                'name' => 'NON SHIFT',
                'start_hour' => '08:00:00',
                'end_hour' => '17:00:00',
                'created_by' => NULL,
                'updated_by' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2020-02-24 21:23:39',
                'updated_at' => '2020-02-24 21:23:39',
            ),
        ));
        
        
    }
}