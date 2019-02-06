<?php

use Illuminate\Database\Seeder;

class MasterJustificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('master_justification')->insert([
            'name' => 'Pertukaran Pegawai Kesatuan'
        ]);

        DB::table('master_justification')->insert([
            'name' => 'Perpindahan Pegawai Kesatuan'
        ]);

        DB::table('master_justification')->insert([
            'name' => 'Perpindahan Ke Bangunan Lain'
        ]);

        DB::table('master_justification')->insert([
            'name' => 'Perpindahan Ke Bangunan Kesatuan Yang Baru'
        ]);

        DB::table('master_justification')->insert([
            'name' => 'Perpindahan Kerana Majikan Berpindah'
        ]);

        DB::table('master_justification')->insert([
            'name' => 'Lain-Lain Sebab Perubahan Alamat'
        ]);
    }
}
