<?php

use Illuminate\Database\Seeder;

class MasterSectorCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        DB::table('master_sector_category')->insert([
            'name' => 'Kementerian',
            'sector_id' => '1'
        ]);

        DB::table('master_sector_category')->insert([
            'name' => 'Jabatan',
            'sector_id' => '1'
        ]);

        DB::table('master_sector_category')->insert([
            'name' => 'Pekerjaan',
            'sector_id' => '1'
        ]);

        DB::table('master_sector_category')->insert([
            'name' => 'Tred',
            'sector_id' => '2'
        ]);

        DB::table('master_sector_category')->insert([
            'name' => 'Industri',
            'sector_id' => '2'
        ]);

        DB::table('master_sector_category')->insert([
            'name' => 'Pekerjaan',
            'sector_id' => '2'
        ]);

        DB::table('master_sector_category')->insert([
            'name' => 'Penubuhan',
            'sector_id' => '2'
        ]);
    }
}
