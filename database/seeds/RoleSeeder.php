<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('role')->insert(array(
            'name' => 'admin',
            'guard_name' => 'web',
            'description' => 'Pentadbir Sistem',
        ));

        DB::table('role')->insert(array(
            'name' => 'staff',
            'guard_name' => 'web',
            'description' => 'Pengguna Dalaman',
        ));

        DB::table('role')->insert(array(
            'name' => 'ks',
            'guard_name' => 'web',
            'description' => 'Pengguna Luaran',
        ));

        DB::table('role')->insert(array(
            'name' => 'union',
            'guard_name' => 'web',
            'description' => 'Kesatuan Sekerja',
        ));

        DB::table('role')->insert(array(
            'name' => 'federation',
            'guard_name' => 'web',
            'description' => 'Persekutuan Kesatuan Sekerja',
        ));

        DB::table('role')->insert(array(
            'name' => 'ptw',
            'guard_name' => 'web',
            'description' => 'Pembantu Tadbir Wilayah',
        ));

        DB::table('role')->insert(array(
            'name' => 'ppw',
            'guard_name' => 'web',
            'description' => 'Penolong Pengarah Wilayah',
        ));

        DB::table('role')->insert(array(
            'name' => 'pw',
            'guard_name' => 'web',
            'description' => 'Pengarah Wilayah',
        ));

        DB::table('role')->insert(array(
            'name' => 'pthq',
            'guard_name' => 'web',
            'description' => 'Pembantu Tadbir Ibu Pejabat (HQ)',
        ));

        DB::table('role')->insert(array(
            'name' => 'pphq',
            'guard_name' => 'web',
            'description' => 'Penolong Pengarah Ibu Pejabat (HQ)',
        ));

        DB::table('role')->insert(array(
            'name' => 'pkpp',
            'guard_name' => 'web',
            'description' => 'Pengarah Kanan Perundangan dan Penguatkuasaan',
        ));

        DB::table('role')->insert(array(
            'name' => 'pkpg',
            'guard_name' => 'web',
            'description' => 'Pengarah Kanan Pergerakan Kesatuan',
        ));

        DB::table('role')->insert(array(
            'name' => 'ppkpg',
            'guard_name' => 'web',
            'description' => 'Penolong Pengarah Kanan Pergerakan Kesatuan',
        ));

        DB::table('role')->insert(array(
            'name' => 'ppkpp',
            'guard_name' => 'web',
            'description' => 'Penolong Pengarah Kanan Perundangan dan Penguatkuasaan',
        ));

        DB::table('role')->insert(array(
            'name' => 'bpl',
            'guard_name' => 'web',
            'description' => 'Bahagian Pengurusan Laporan',
        ));

        DB::table('role')->insert(array(
            'name' => 'tkpks',
            'guard_name' => 'web',
            'description' => 'Timbalan Ketua Pengarah Kesatuan Sekerja',
        ));

        DB::table('role')->insert(array(
            'name' => 'kpks',
            'guard_name' => 'web',
            'description' => 'Ketua Pengarah Kesatuan Sekerja',
        ));

        DB::table('role')->insert(array(
            'name' => 'puu',
            'guard_name' => 'web',
            'description' => 'Pegawai Undang-Undang',
        ));

        DB::table('role')->insert(array(
            'name' => 'io',
            'guard_name' => 'web',
            'description' => 'Pegawai Penyiasat',
        ));

        DB::table('role')->insert(array(
            'name' => 'po',
            'guard_name' => 'web',
            'description' => 'Pegawai Pendakwa',
        ));
    }
}
