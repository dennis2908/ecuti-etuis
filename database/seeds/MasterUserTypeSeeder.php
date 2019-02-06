<?php

use Illuminate\Database\Seeder;

class MasterUserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_user_type')->insert([
            'name' => 'Pentadbir'
        ]);

        DB::table('master_user_type')->insert([
            'name' => 'Pegawai'
        ]);

        DB::table('master_user_type')->insert([
            'name' => 'Kesatuan Sekerja'
        ]);

        DB::table('master_user_type')->insert([
            'name' => 'Persekutuan Kesatuan Sekerja'
        ]);
    }
}
