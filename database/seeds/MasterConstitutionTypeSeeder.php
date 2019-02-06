<?php

use Illuminate\Database\Seeder;

class MasterConstitutionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        DB::table('master_constitution_type')->insert([
            'name' => 'B3',
        ]);

        DB::table('master_constitution_type')->insert([
            'name' => 'B4',
        ]);

        DB::table('master_constitution_type')->insert([
            'name' => 'BB3',
        ]);
    }
}
