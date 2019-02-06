<?php

use Illuminate\Database\Seeder;

class MasterProgrammeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_programme_type')->insert([
            'name' => 'Persidangan Perwakilan',   
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Mesyuarat Agung',  
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Mesyuarat Agung Luar Biasa',   
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Kursus',  
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Seminar',   
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Bengkel',  
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Persidangan',   
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Latihan',  
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Konvensyen',   
        ]);
        DB::table('master_programme_type')->insert([
            'name' => 'Wacana',  
        ]);
    }
}
