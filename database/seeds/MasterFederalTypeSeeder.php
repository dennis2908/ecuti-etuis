<?php

use Illuminate\Database\Seeder;

class MasterFederationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_federation_type')->insert([
            'name' => 'Majikan-Majikan',
        ]);

        DB::table('master_federation_type')->insert([
            'name' => 'Pekerja-Pekerja',
        ]);
    }
}
