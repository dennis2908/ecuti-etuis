<?php

use Illuminate\Database\Seeder;

class MasterAddressTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_address_type')->insert([
            'name' => 'Tempat Majikan'
        ]);

        DB::table('master_address_type')->insert([
            'name' => 'Alamat Pejabat Kesatuan'
        ]);

        DB::table('master_address_type')->insert([
            'name' => 'Alamat Rumah'
        ]);
    }
}
