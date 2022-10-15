<?php



use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'menu-index',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'menu-create',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'menu-update',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'menu-delete',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'user-index',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'user-create',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'user-update',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'user-delete',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'role-index',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'role-create',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'role-update',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'role-delete',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'permission-index',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'permission-create',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'permission-update',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'permission-delete',
                'guard_name' => 'web',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'taxs-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'taxs-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'taxs-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'taxs-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'tax_group_history-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'tax_group_history-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'tax_group_history-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'tax_group_history-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:28:08',
                'updated_at' => '2022-09-21 15:28:08',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'absent_reasons-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:11',
                'updated_at' => '2022-09-21 15:29:11',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'absent_reasons-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:11',
                'updated_at' => '2022-09-21 15:29:11',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'absent_reasons-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:11',
                'updated_at' => '2022-09-21 15:29:11',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'absent_reasons-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:11',
                'updated_at' => '2022-09-21 15:29:11',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'education_titles-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'education_titles-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'education_titles-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'education_titles-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'educational_institutes-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'educational_institutes-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'educational_institutes-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'educational_institutes-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:12',
                'updated_at' => '2022-09-21 15:29:12',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'contracts-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:13',
                'updated_at' => '2022-09-21 15:29:13',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'contracts-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:13',
                'updated_at' => '2022-09-21 15:29:13',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'contracts-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:13',
                'updated_at' => '2022-09-21 15:29:13',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'contracts-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:13',
                'updated_at' => '2022-09-21 15:29:13',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'employees-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'employees-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'employees-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'employees-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'holidays-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'holidays-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'holidays-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'holidays-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:14',
                'updated_at' => '2022-09-21 15:29:14',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'job_levels-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'job_levels-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'job_levels-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'job_levels-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'job_mutations-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'job_mutations-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'job_mutations-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'job_mutations-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:15',
                'updated_at' => '2022-09-21 15:29:15',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'job_placements-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'job_placements-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'job_placements-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'job_placements-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'job_titles-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'job_titles-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'job_titles-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'job_titles-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:16',
                'updated_at' => '2022-09-21 15:29:16',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'attendance_logfingers-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'attendance_logfingers-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'attendance_logfingers-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'attendance_logfingers-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'attendance_summaries-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'attendance_summaries-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'attendance_summaries-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'attendance_summaries-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:29:59',
                'updated_at' => '2022-09-21 15:29:59',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'attendances-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'attendances-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'attendances-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'attendances-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'career_histories-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'career_histories-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'career_histories-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'career_histories-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:00',
                'updated_at' => '2022-09-21 15:30:00',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'employee_shiftments-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'employee_shiftments-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'employee_shiftments-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'employee_shiftments-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'fingerprint_devices-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'fingerprint_devices-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'fingerprint_devices-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'fingerprint_devices-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:01',
                'updated_at' => '2022-09-21 15:30:01',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'leaves-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'leaves-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'leaves-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'leaves-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'overtimes-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'overtimes-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'overtimes-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:02',
                'updated_at' => '2022-09-21 15:30:02',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'overtimes-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:03',
                'updated_at' => '2022-09-21 15:30:03',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'salary_allowances-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:03',
                'updated_at' => '2022-09-21 15:30:03',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'salary_allowances-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:03',
                'updated_at' => '2022-09-21 15:30:03',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'salary_allowances-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:03',
                'updated_at' => '2022-09-21 15:30:03',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'salary_allowances-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:03',
                'updated_at' => '2022-09-21 15:30:03',
            ),
        ));
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 101,
                'name' => 'salary_benefit_histories-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            1 => 
            array (
                'id' => 102,
                'name' => 'salary_benefit_histories-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            2 => 
            array (
                'id' => 103,
                'name' => 'salary_benefit_histories-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            3 => 
            array (
                'id' => 104,
                'name' => 'salary_benefit_histories-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            4 => 
            array (
                'id' => 105,
                'name' => 'salary_benefits-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            5 => 
            array (
                'id' => 106,
                'name' => 'salary_benefits-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            6 => 
            array (
                'id' => 107,
                'name' => 'salary_benefits-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            7 => 
            array (
                'id' => 108,
                'name' => 'salary_benefits-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:04',
                'updated_at' => '2022-09-21 15:30:04',
            ),
            8 => 
            array (
                'id' => 109,
                'name' => 'salary_components-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:05',
                'updated_at' => '2022-09-21 15:30:05',
            ),
            9 => 
            array (
                'id' => 110,
                'name' => 'salary_components-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:05',
                'updated_at' => '2022-09-21 15:30:05',
            ),
            10 => 
            array (
                'id' => 111,
                'name' => 'salary_components-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:05',
                'updated_at' => '2022-09-21 15:30:05',
            ),
            11 => 
            array (
                'id' => 112,
                'name' => 'salary_components-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:05',
                'updated_at' => '2022-09-21 15:30:05',
            ),
            12 => 
            array (
                'id' => 113,
                'name' => 'salary_group_details-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:05',
                'updated_at' => '2022-09-21 15:30:05',
            ),
            13 => 
            array (
                'id' => 114,
                'name' => 'salary_group_details-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:05',
                'updated_at' => '2022-09-21 15:30:05',
            ),
            14 => 
            array (
                'id' => 115,
                'name' => 'salary_group_details-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:06',
                'updated_at' => '2022-09-21 15:30:06',
            ),
            15 => 
            array (
                'id' => 116,
                'name' => 'salary_group_details-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:06',
                'updated_at' => '2022-09-21 15:30:06',
            ),
            16 => 
            array (
                'id' => 117,
                'name' => 'salary_groups-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:41',
                'updated_at' => '2022-09-21 15:30:41',
            ),
            17 => 
            array (
                'id' => 118,
                'name' => 'salary_groups-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:41',
                'updated_at' => '2022-09-21 15:30:41',
            ),
            18 => 
            array (
                'id' => 119,
                'name' => 'salary_groups-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:41',
                'updated_at' => '2022-09-21 15:30:41',
            ),
            19 => 
            array (
                'id' => 120,
                'name' => 'salary_groups-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:41',
                'updated_at' => '2022-09-21 15:30:41',
            ),
            20 => 
            array (
                'id' => 121,
                'name' => 'shiftment_groups-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            21 => 
            array (
                'id' => 122,
                'name' => 'shiftment_groups-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            22 => 
            array (
                'id' => 123,
                'name' => 'shiftment_groups-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            23 => 
            array (
                'id' => 124,
                'name' => 'shiftment_groups-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            24 => 
            array (
                'id' => 125,
                'name' => 'shiftments-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            25 => 
            array (
                'id' => 126,
                'name' => 'shiftments-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            26 => 
            array (
                'id' => 127,
                'name' => 'shiftments-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            27 => 
            array (
                'id' => 128,
                'name' => 'shiftments-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:42',
                'updated_at' => '2022-09-21 15:30:42',
            ),
            28 => 
            array (
                'id' => 129,
                'name' => 'skill_groups-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:43',
                'updated_at' => '2022-09-21 15:30:43',
            ),
            29 => 
            array (
                'id' => 130,
                'name' => 'skill_groups-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:43',
                'updated_at' => '2022-09-21 15:30:43',
            ),
            30 => 
            array (
                'id' => 131,
                'name' => 'skill_groups-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:43',
                'updated_at' => '2022-09-21 15:30:43',
            ),
            31 => 
            array (
                'id' => 132,
                'name' => 'skill_groups-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:43',
                'updated_at' => '2022-09-21 15:30:43',
            ),
            32 => 
            array (
                'id' => 133,
                'name' => 'skills-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            33 => 
            array (
                'id' => 134,
                'name' => 'skills-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            34 => 
            array (
                'id' => 135,
                'name' => 'skills-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            35 => 
            array (
                'id' => 136,
                'name' => 'skills-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            36 => 
            array (
                'id' => 137,
                'name' => 'workshifts-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            37 => 
            array (
                'id' => 138,
                'name' => 'workshifts-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            38 => 
            array (
                'id' => 139,
                'name' => 'workshifts-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            39 => 
            array (
                'id' => 140,
                'name' => 'workshifts-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            40 => 
            array (
                'id' => 141,
                'name' => 'departments-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            41 => 
            array (
                'id' => 142,
                'name' => 'departments-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            42 => 
            array (
                'id' => 143,
                'name' => 'departments-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            43 => 
            array (
                'id' => 144,
                'name' => 'departments-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            44 => 
            array (
                'id' => 145,
                'name' => 'cities-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            45 => 
            array (
                'id' => 146,
                'name' => 'cities-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            46 => 
            array (
                'id' => 147,
                'name' => 'cities-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            47 => 
            array (
                'id' => 148,
                'name' => 'cities-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            48 => 
            array (
                'id' => 149,
                'name' => 'companies-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            49 => 
            array (
                'id' => 150,
                'name' => 'companies-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            50 => 
            array (
                'id' => 151,
                'name' => 'companies-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            51 => 
            array (
                'id' => 152,
                'name' => 'companies-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            52 => 
            array (
                'id' => 153,
                'name' => 'regions-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            53 => 
            array (
                'id' => 154,
                'name' => 'regions-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            54 => 
            array (
                'id' => 155,
                'name' => 'regions-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            55 => 
            array (
                'id' => 156,
                'name' => 'regions-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            56 => 
            array (
                'id' => 157,
                'name' => 'settings-index',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            57 => 
            array (
                'id' => 158,
                'name' => 'settings-create',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            58 => 
            array (
                'id' => 159,
                'name' => 'settings-update',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            59 => 
            array (
                'id' => 160,
                'name' => 'settings-delete',
                'guard_name' => 'web',
                'created_at' => '2022-09-21 15:30:44',
                'updated_at' => '2022-09-21 15:30:44',
            ),
            60 => 
            array (
                'id' => 161,
                'name' => 'payroll_periods-index',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:07',
                'updated_at' => '2022-10-04 11:17:07',
            ),
            61 => 
            array (
                'id' => 162,
                'name' => 'payroll_periods-create',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:07',
                'updated_at' => '2022-10-04 11:17:07',
            ),
            62 => 
            array (
                'id' => 163,
                'name' => 'payroll_periods-update',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:07',
                'updated_at' => '2022-10-04 11:17:07',
            ),
            63 => 
            array (
                'id' => 164,
                'name' => 'payroll_periods-delete',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:07',
                'updated_at' => '2022-10-04 11:17:07',
            ),
            64 => 
            array (
                'id' => 165,
                'name' => 'payrolls-index',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            65 => 
            array (
                'id' => 166,
                'name' => 'payrolls-create',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            66 => 
            array (
                'id' => 167,
                'name' => 'payrolls-update',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            67 => 
            array (
                'id' => 168,
                'name' => 'payrolls-delete',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            68 => 
            array (
                'id' => 169,
                'name' => 'payroll_details-index',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            69 => 
            array (
                'id' => 170,
                'name' => 'payroll_details-create',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            70 => 
            array (
                'id' => 171,
                'name' => 'payroll_details-update',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
            71 => 
            array (
                'id' => 172,
                'name' => 'payroll_details-delete',
                'guard_name' => 'web',
                'created_at' => '2022-10-04 11:17:08',
                'updated_at' => '2022-10-04 11:17:08',
            ),
        ));
        
        
    }
}