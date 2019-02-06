<?php

use Illuminate\Database\Seeder;

class MasterRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_region')->insert([
            'name' => 'Semenanjung Malaysia'
        ]);

        DB::table('master_region')->insert([
            'name' => 'Sabah'
        ]);

        DB::table('master_region')->insert([
            'name' => 'Sarawak'
        ]);
    }
}
