<?php

use Illuminate\Database\Seeder;

class MasterSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_sector')->insert([
            'name' => 'Kerajaan'
        ]);

        DB::table('master_sector')->insert([
            'name' => 'Swasta'
        ]);

        DB::table('master_sector')->insert([
            'name' => 'Badan Berkanun'
        ]);
    }
}
