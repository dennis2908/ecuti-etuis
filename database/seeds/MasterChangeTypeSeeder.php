<?php

use Illuminate\Database\Seeder;

class MasterChangeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_change_type')->insert([
            'name' => 'Tambah Baru'
        ]);

        DB::table('master_change_type')->insert([
            'name' => 'Kemaskini'
        ]);

        DB::table('master_change_type')->insert([
            'name' => 'Padam'
        ]);
    }
}
