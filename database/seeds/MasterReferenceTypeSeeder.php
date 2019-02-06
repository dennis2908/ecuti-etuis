<?php

use Illuminate\Database\Seeder;

class MasterReferenceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_reference_type')->insert([
            'name' => 'PWN',
        ]);

        DB::table('master_reference_type')->insert([
            'name' => 'HQ',
        ]);
    }
}
