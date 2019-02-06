<?php

use Illuminate\Database\Seeder;

class MasterPartyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_party_type')->insert([
            'name' => 'Ahli / Pegawai Kesatuan',   
        ]);
        DB::table('master_party_type')->insert([
            'name' => 'Individu Bukan Ahli',  
        ]);
        DB::table('master_party_type')->insert([
            'name' => 'Agensi / Syarikat Luar',   
        ]);
    }
}
