<?php

use Illuminate\Database\Seeder;

class MasterStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_state')->insert([
            'name' => 'Johor',
            'is_friday_weekend' => 1,
            'province_office_id' => 5,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Kedah',
            'is_friday_weekend' => 1,
            'province_office_id' => 6,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Kelantan',
            'is_friday_weekend' => 1,
            'province_office_id' => 4,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Melaka',
            'is_friday_weekend' => 0,
            'province_office_id' => 2,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Negeri Sembilan',
            'is_friday_weekend' => 0,
            'province_office_id' => 2,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Pahang',
            'is_friday_weekend' => 0,
            'province_office_id' => 3,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Pulau Pinang',
            'is_friday_weekend' => 0,
            'province_office_id' => 6,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Perak',
            'is_friday_weekend' => 0,
            'province_office_id' => 9,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Perlis',
            'is_friday_weekend' => 0,
            'province_office_id' => 6,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Selangor',
            'is_friday_weekend' => 0,
            'province_office_id' => 1,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Terengganu',
            'is_friday_weekend' => 1,
            'province_office_id' => 4,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Sabah',
            'is_friday_weekend' => 0,
            'province_office_id' => 7,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Sarawak',
            'is_friday_weekend' => 0,
            'province_office_id' => 8,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Wilayah Persekutuan Kuala Lumpur',
            'is_friday_weekend' => 0,
            'province_office_id' => 1,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Wilayah Persekutuan Labuan',
            'is_friday_weekend' => 0,
            'province_office_id' => 7,
        ]);
        DB::table('master_state')->insert([
            'name' => 'Wilayah Persekutuan Putrajaya',
            'is_friday_weekend' => 0,
            'province_office_id' => 1,
        ]);
    }
}
