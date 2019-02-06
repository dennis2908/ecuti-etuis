<?php

use Illuminate\Database\Seeder;

class MasterUserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_user_status')->insert([
            'name' => 'Aktif'
        ]);

        DB::table('master_user_status')->insert([
            'name' => 'Ditolak'
        ]);

        DB::table('master_user_status')->insert([
            'name' => 'Belum Disahkan'
        ]);

        DB::table('master_user_status')->insert([
            'name' => 'Disekat'
        ]);
    }
}
