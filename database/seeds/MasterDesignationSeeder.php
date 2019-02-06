<?php

use Illuminate\Database\Seeder;

class MasterDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_designation')->insert([
            'name' => 'Presiden',
        ]);

        DB::table('master_designation')->insert([
            'name' => 'Naib Presiden',
        ]);

        DB::table('master_designation')->insert([
            'name' => 'Setiausaha',
        ]);

        DB::table('master_designation')->insert([
            'name' => 'Naib Setiausaha',
        ]);

        DB::table('master_designation')->insert([
            'name' => 'Bendahari',
        ]);

        DB::table('master_designation')->insert([
            'name' => 'Naib Bendahari',
        ]);

        DB::table('master_designation')->insert([
            'name' => 'Ahli Jawatankuasa',
        ]);
    }
}
