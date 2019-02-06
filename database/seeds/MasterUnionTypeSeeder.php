<?php

use Illuminate\Database\Seeder;

class MasterUnionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_union_type')->insert([
            'name' => 'Majikan'
        ]);

        DB::table('master_union_type')->insert([
            'name' => 'Pekerja'
        ]);
    }
}
